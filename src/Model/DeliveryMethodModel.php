<?php

namespace App\Model;

use App\Entity\DeliveryMethod;
use Doctrine\ORM\EntityManagerInterface;

class DeliveryMethodModel
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
            ->getRepository(DeliveryMethod::class)
            ->createQueryBuilder('d');
    }

    public function find($id)
    {
        return $this->entityManager->getRepository(DeliveryMethod::class)
            ->find($id);
    }
}
