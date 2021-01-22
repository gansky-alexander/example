<?php

namespace App\Model;

use App\Entity\Brand;
use Doctrine\ORM\EntityManagerInterface;

class BrandModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getQuery()
    {
        return $this->entityManager
            ->getRepository(Brand::class)
            ->createQueryBuilder('b');
    }

    public function findMany($brandIds)
    {
        return $this->entityManager
            ->getRepository(Brand::class)
            ->createQueryBuilder('b')
            ->where('b.id IN (:ids)')
            ->setParameter('ids', $brandIds)
            ->getQuery()
            ->getResult();
    }
}
