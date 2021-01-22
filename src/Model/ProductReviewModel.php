<?php

namespace App\Model;

use App\Entity\Badge;
use App\Entity\Customer;
use App\Entity\OrderEntry;
use App\Entity\Product;
use App\Entity\ProductVariant;
use App\Entity\Review;
use App\Entity\ReviewFile;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductReviewModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var Security */
    protected $security;
    /** @var ValidatorInterface */
    protected $validator;
    /** @var ProductModel */
    protected $productModel;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        ValidatorInterface $validator,
        ProductModel $productModel
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->validator = $validator;
        $this->productModel = $productModel;
    }

    public function find($id)
    {
        return $this->entityManager
            ->getRepository(Review::class)
            ->createQueryBuilder('r')
            ->where('r.customer = :customer AND r.id = :id')
            ->setParameters([
                'customer' => $this->security->getUser(),
                'id' => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
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

    public function addProductReview($content)
    {
        if (!isset($content['product'])) {
            throw new ValidatorException('Parameter "product" should be specified.');
        }

        /** @var Product $product */
        $product = $this->productModel->find($content['product']);

        if (!$product) {
            throw new NotFoundHttpException('Product is not found.');
        }

        $orders = $this->entityManager
            ->getRepository(OrderEntry::class)
            ->createQueryBuilder('oe')
            ->select('count(o) as count')
            ->innerJoin('oe.order', 'o')
            ->innerJoin('oe.productVariant', 'pv')
            ->innerJoin('pv.product', 'p')
            ->where('o.customer = :customer AND p.id = :product')
            ->setParameters([
                'customer' => $this->security->getUser(),
                'product' => $product,
            ])
            ->getQuery()
            ->getSingleScalarResult();

        if ($orders == 0) {
            throw new AccessDeniedException('You do not have permission to create Review for this product cause you do not have any order with it.');
        }

        $review = new Review();
        $review->setCreatedAt(new \DateTime());
        $review->setCustomer($this->security->getUser());
        $review->setProduct($product);
        $review->setText($content['text']);
        $review->setRate($content['rate']);
        $review->setIsActive(true);

        $errors = $this->validator->validate($review, null, ['general']);

        if ($errors->count() > 0) {
            return $this->prepareError($errors);
        }

        $this->entityManager->persist($review);
        $this->entityManager->flush();

        $this->productModel->recalculateProductReviewsTotal($product);

        return $review;
    }

    public function addProductReviewFile($content)
    {
        /** @var Review $review */
        $review = $this->find($content['review_id']);

        $reviewFile = new ReviewFile();
        $reviewFile->setReview($review);

        $fileName = "review.jpg";
        $imagePath = "/images/reviews/{$review->getId()}";

        if (!is_dir('.' . $imagePath)) {
            mkdir('.' . $imagePath, 0777, true);
        }
        $reviewFile->setPath($imagePath . '/' . $fileName);

        $this->entityManager->persist($reviewFile);

        file_put_contents('.' . $imagePath . '/' . $fileName, base64_decode($content['content']));

        $this->entityManager->flush();

        return $this->getReviews();
    }

    public function updateProductReview($content)
    {
        /** @var Review $review */
        $review = $this->find($content['review_id']);

        if (!$review || $review->getCustomer()->getId() != $this->security->getUser()->getId()) {
            throw new NotFoundHttpException('Review does not found.');
        }

        $review->setText($content['text']);
        $review->setRate($content['rate']);

        $errors = $this->validator->validate($review, null, ['general']);

        if ($errors->count() > 0) {
            return $this->prepareError($errors);
        }

        $this->entityManager->persist($review);
        $this->entityManager->flush();

        $this->productModel->recalculateProductReviewsTotal($review->getProduct());

        return $review;
    }

    public function remove(Review $review)
    {
        if ($review->getCustomer()->getId() != $this->security->getUser()->getId()) {
            throw new NotFoundHttpException('Review is not found');
        }

        $this->productModel->recalculateProductReviewsTotal($review->getProduct());

        $this->entityManager->remove($review);
        $this->entityManager->flush();
    }
}

