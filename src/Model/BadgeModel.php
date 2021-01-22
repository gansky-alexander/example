<?php

namespace App\Model;

use App\Entity\Badge;
use Doctrine\ORM\EntityManagerInterface;

class BadgeModel
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
            ->getRepository(Badge::class)
            ->createQueryBuilder('b');
    }
}
