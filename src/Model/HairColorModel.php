<?php

namespace App\Model;

use App\Entity\HairColor;
use Doctrine\ORM\EntityManagerInterface;

class HairColorModel
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
            ->getRepository(HairColor::class)
            ->createQueryBuilder('hc');
    }

    public function find($id)
    {
        if (!$id) {
            return null;
        }

        return $this->entityManager
            ->getRepository(HairColor::class)
            ->find($id);
    }
}
