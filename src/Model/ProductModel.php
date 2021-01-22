<?php

namespace App\Model;

use App\Entity\Badge;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ProductVariant;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var Security */
    protected $security;
    /** @var ValidatorInterface */
    protected $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        ValidatorInterface $validator
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->validator = $validator;
    }

    public function getQuery(
        $search,
        $badges,
        $categories,
        $brands,
        $ids,
        $priceFrom,
        $priceTo,
        $usedForBox,
        $order,
        $badgeOrderValue
    )
    {
        $query = $this->entityManager
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->innerJoin('p.translations', 't')
            ->where('p.isActive = :isActive')
            ->setParameter('isActive', true);

        if ($search) {
            $ors = [];
            foreach (explode(' ', trim($search)) as $item) {
                $item = trim($item);
                $ors[] = "t.name LIKE '%$item%'";
            }
            $query
                ->andWhere(implode(" OR ", $ors));
        }

        if ($badges) {
            $query->innerJoin('p.badges', 'b')
                ->andWhere('b.id IN (:badges)')
                ->setParameter('badges', explode(',', $badges));
        }

        if ($categories) {
            $query->innerJoin('p.categories', 'c')
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', explode(',', $categories));
        }

        if ($brands) {
            $query->innerJoin('p.brand', 'br')
                ->andWhere('br.id IN (:brands)')
                ->setParameter('brands', explode(',', $brands));
        }

        if ($ids) {
            $query->andWhere('p.id IN (:ids)')
                ->setParameter('ids', explode(',', $ids));
        }

        if ($priceFrom) {
            $query->andWhere('p.price >= :from')
                ->setParameter('from', $priceFrom);
        }

        if ($priceTo) {
            $query->andWhere('p.price <= :to')
                ->setParameter('to', $priceTo);
        }

        if ($usedForBox === true) {
            $query->andWhere('p.usedForBox = :usedForBox')
                ->setParameter('usedForBox', $usedForBox);
        }

        if ($usedForBox === false) {
            $query->andWhere('p.usedForBox = :usedForBox OR p.usedForBox IS NULL')
                ->setParameter('usedForBox', $usedForBox);
        }

        if ($order) {
            switch ($order) {
                case "price-asc":
                    $query->orderBy('p.price', 'ASC');
                    break;
                case "price-desc":
                    $query->orderBy('p.price', 'DESC');
                    break;
                case "badge":
                    /** @var Badge $badge */
                    $badge = $this->entityManager->getRepository(Badge::class)
                        ->find($badgeOrderValue);
                    if ($badge && $badge->getUsedForSort()) {
                        $query
                            ->leftJoin(
                                'p.badges',
                                'bsort',
                                Join::WITH,
                                'bsort.id = :bsort'
                            )
                            ->setParameter('bsort', $badge)
                            ->addOrderBy('bsort.sortOrder', 'DESC');
                    }
                    break;
            }
        }

        return $query;
    }

    public function find($id)
    {
        return $this->entityManager->getRepository(Product::class)
            ->find($id);
    }

    public function findVariant($id)
    {
        return $this->entityManager
            ->getRepository(ProductVariant::class)
            ->find($id);
    }

    public function getFavourites()
    {
        return $this->security->getUser()->getFavouriteProducts();
    }

    public function addFavourites(Product $product)
    {
        /** @var Customer $user */
        $customer = $this->security->getUser();

        $customer->addFavouriteProduct($product);
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    public function removeFavourites(Product $product)
    {
        /** @var Customer $user */
        $customer = $this->security->getUser();

        $customer->removeFavouriteProduct($product);
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    public function getReviews()
    {
        return $this->entityManager
            ->getRepository(Review::class)
            ->createQueryBuilder('r')
            ->where('r.customer = :customer')
            ->setParameters([
                'customer' => $this->security->getUser(),
            ])
            ->getQuery()
            ->getResult();
    }

    public function recalculateProductReviewsTotal(Product $product)
    {

        $reviews = $this->entityManager
            ->getRepository(Review::class)
            ->createQueryBuilder('r')
            ->where('r.product = :product')
            ->setParameter('product', $product)
            ->getQuery()
            ->getResult();

        if (count($reviews) == 0) {
            return;
        }

        $amountOfReviews = 0;
        $totalSumOfReviews = 0;
        /** @var Review $review */
        foreach ($reviews as $review) {
            $amountOfReviews++;
            $totalSumOfReviews += $review->getRate();
        }

        $rating = number_format((float)$totalSumOfReviews / $amountOfReviews, 2, '.', '');

        $product->setAmountOfReviews($amountOfReviews);
        $product->setRating($rating);

        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function findActiveReviewsByProductId($productId)
    {
        return $this->entityManager
            ->getRepository(Review::class)
            ->createQueryBuilder('r')
            ->where('r.product = :productId AND r.isActive = :active')
            ->setParameters([
                'productId' => $productId,
                'active' => true,
            ])
            ->getQuery()
            ->getResult();
    }
}

