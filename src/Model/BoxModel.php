<?php

namespace App\Model;

use App\Dto\ApiError;
use App\Entity\Box;
use App\Entity\BoxItem;
use App\Entity\Customer;
use App\Entity\ProductVariant;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Security\Core\Security;

class BoxModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var Security */
    protected $security;

    /** @var ProductModel */
    protected $productModel;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        ProductModel $productModel)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->productModel = $productModel;
    }

    public function generateBoxes(\DateTimeInterface $date)
    {
        $customers = $this->entityManager
            ->getRepository(Customer::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.boxes', 'b', Join::WITH, 'b.date = :date')
            ->where('b.id IS NULL')
            ->setParameter('date', $date->format('Y-m-01'))
            ->getQuery()
            ->getResult();

        /** @var Customer $customer */
        foreach ($customers as $customer) {
            $box = new Box();

            $box->setCustomer($customer);
            $box->setIsFinished(false);
            $box->setDate(new \DateTime($date->format('Y-m-01')));
            $this->entityManager->persist($box);
        }

        $this->entityManager->flush();
    }

    public function getQuery()
    {
        return $this->entityManager
            ->getRepository(Box::class)
            ->createQueryBuilder('b')
            ->where('b.customer = :customer')
            ->setParameter('customer', $this->security->getUser());
    }

    public function find($id)
    {
        return $this->getQuery()
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Box $box
     * @param array $data
     *
     * @return ApiError|Box
     */
    public function addVariant(Box $box, $data)
    {
        if (!isset($data['product'])) {
            $apiError = new ApiError();

            $apiError->addError(
                'product',
                "Parameter 'product' should be specified"
            );

            return $apiError;
        }
        $id = $data['product'];
        /** @var ProductVariant $variant */
        $variant = $this->productModel->findVariant($id);

        if (!$variant || !$variant->getProduct()->getIsActive()) {
            $apiError = new ApiError();

            $apiError->addError(
                'product',
                "Product variant does not exists"
            );

            return $apiError;
        }

        if ($variant && !$variant->getProduct()->getUsedForBox()) {
            $apiError = new ApiError();

            $apiError->addError(
                'product',
                "Product variant can't be used for box"
            );

            return $apiError;
        }

        if ($box->getIsFinished()) {
            $apiError = new ApiError();

            $apiError->addError(
                'product',
                "You can't add more products to your box, time is left"
            );

            return $apiError;
        }

        $countOfMyVariants = 0;

        foreach ($box->getItems() as $item) {
            if ($item->getCreatedBy() == BoxItem::CREATED_BY_ME) {
                $countOfMyVariants++;
            }
        }

        if ($countOfMyVariants == 2) {
            $apiError = new ApiError();

            $apiError->addError(
                'product',
                "You can't add more products to your box, you added 2 products already."
            );

            return $apiError;
        }

        $boxItem = new BoxItem();
        $boxItem->setBox($box);
        $boxItem->setCreatedBy(BoxItem::CREATED_BY_ME);
        $boxItem->setVariant($variant);

        $this->entityManager->persist($boxItem);
        $this->entityManager->persist($box);
        $this->entityManager->flush();

        $this->entityManager->refresh($box);

        return $box;
    }
}
