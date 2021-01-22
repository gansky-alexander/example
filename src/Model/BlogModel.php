<?php

namespace App\Model;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;

class BlogModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getQuery(
        $tags,
        $isForYou,
        $isPopular
    )
    {
        $query = $this->entityManager
            ->getRepository(Blog::class)
            ->createQueryBuilder('b')
            ->where('b.isPublished = :isPublished')
            ->setParameter('isPublished', true);

        if (trim($tags)) {
            $query->innerJoin('b.tags', 't')
                ->andWhere('t.id IN (:tags)')
                ->setParameter('tags', explode(',', trim($tags)));
        }

        if ($isForYou && $isForYou === 'true') {
            $query->andWhere('b.isForYou = :isForYou')
                ->setParameter('isForYou', true);
        } elseif ($isForYou && $isForYou === 'false') {
            $query->andWhere('b.isForYou = :isForYou OR b.isForYou IS NULL')
                ->setParameter('isForYou', false);
        }

        if ($isPopular && $isPopular === 'true') {
            $query->andWhere('b.isPopular = :isPopular')
                ->setParameter('isPopular', true);
        } elseif ($isPopular && $isPopular === 'false') {
            $query->andWhere('b.isPopular = :isPopular OR b.isPopular IS NULL')
                ->setParameter('isPopular', false);
        }

        $query
            ->orderBy('b.publishDate', 'desc')
            ->addOrderBy('b.id', 'desc');

        return $query;
    }
}
