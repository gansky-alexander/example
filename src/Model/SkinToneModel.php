<?php

namespace App\Model;

use App\Entity\SkinTone;
use Doctrine\ORM\EntityManagerInterface;

class SkinToneModel
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
            ->getRepository(SkinTone::class)
            ->createQueryBuilder('st');
    }

    public function find($id): ?SkinTone
    {
        if(!$id) {
            return null;
        }

        return $this->entityManager
            ->getRepository(SkinTone::class)
            ->find($id);
    }
}
