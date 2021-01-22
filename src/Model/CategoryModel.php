<?php

namespace App\Model;

use App\Entity\Brand;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getQuery(?Category $parent)
    {
        $query = $this->entityManager
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->addSelect('t')
            ->innerJoin('c.translations', 't');

        if (!is_null($parent)) {
            $query->andWhere('c.parent = :parent')
                ->setParameter('parent', $parent);
        } else {
            $query->andWhere('c.parent IS NULL');
        }

        return $query;
    }

    public function find($id)
    {
        if (!$id) {
            return null;
        }
        return $this->entityManager->getRepository(Category::class)
            ->find($id);
    }

    public function findMany($categoryIds)
    {
        return $this->entityManager
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->where('c.id IN (:ids)')
            ->setParameter('ids', $categoryIds)
            ->getQuery()
            ->getResult();
    }
}
