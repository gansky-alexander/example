<?php

namespace App\Model;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;

class StoreModel
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
            ->getRepository(Store::class)
            ->createQueryBuilder('s');
    }

    public function find($id)
    {
        if(!$id) {
            return null;
        }
        return $this->entityManager->getRepository(Store::class)
            ->find($id);
    }
}
