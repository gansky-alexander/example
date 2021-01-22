<?php

namespace App\Model;

use App\Entity\Review;
use App\Entity\ReviewLike;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ReviewModel
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var Security */
    protected $security;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function likeReview(Review $review)
    {
        $like = $this->entityManager->getRepository(ReviewLike::class)
            ->findOneBy([
                'customer' => $this->security->getUser(),
                'review' => $review,
            ]);

        if (!$like) {
            $like = new ReviewLike();
            $like->setReview($review);
            $like->setCustomer($this->security->getUser());
        }

        $this->entityManager->persist($like);
        $this->entityManager->flush();

        return $like;
    }

    public function unlikeReview(Review $review)
    {
        $like = $this->entityManager->getRepository(ReviewLike::class)
            ->findOneBy([
                'customer' => $this->security->getUser(),
                'review' => $review,
            ]);

        if ($like) {
            $this->entityManager->remove($like);
            $this->entityManager->flush();
        }

        return [];
    }

    public function find($id)
    {
        return $this->entityManager
            ->getRepository(Review::class)
            ->createQueryBuilder('r')
            ->where('r.id = :id AND r.isActive = :isActive')
            ->setParameters([
                'id' => $id,
                'isActive' => true,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
