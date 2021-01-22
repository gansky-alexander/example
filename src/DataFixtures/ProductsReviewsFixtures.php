<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use App\Entity\Review;
use App\Entity\ReviewFile;
use App\Entity\ReviewLike;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductsReviewsFixtures extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $reviews = [
            1 => [
                'customer' => $this->getReference('customer_alexander.gansky@gmail.com'),
                'product' => $this->getReference('product_a'),
                'text' => 'Review for product #1',
                'rate' => 4.9,
                'createdAt' => new \DateTime(),
                'files' => [
                    '/images/reviews/1.jpg',
                ],
                'likesCustomer' => [
                    $this->getReference('customer_alexander.gansky@gmail.com'),
                    $this->getReference('customer_petrov@gmail.com'),
                    $this->getReference('customer_sidorova@gmail.com'),
                ],
            ],
            [
                'customer' => $this->getReference('customer_alexander.gansky@gmail.com'),
                'product' => $this->getReference('product_b'),
                'text' => 'Review for product #2',
                'rate' => 4.4,
                'createdAt' => new \DateTime(),
                'files' => [
                    '/images/reviews/1.jpg',
                ],
                'likesCustomer' => [
                    $this->getReference('customer_alexander.gansky@gmail.com'),
                    $this->getReference('customer_petrov@gmail.com'),
                    $this->getReference('customer_sidorova@gmail.com'),
                ],
            ],
            [
                'customer' => $this->getReference('customer_alexander.gansky@gmail.com'),
                'product' => $this->getReference('product_c'),
                'text' => 'Review for product #3',
                'rate' => 4.1,
                'createdAt' => new \DateTime(),
                'files' => [
                    '/images/reviews/1.jpg',
                ],
                'likesCustomer' => [
                    $this->getReference('customer_alexander.gansky@gmail.com'),
                    $this->getReference('customer_petrov@gmail.com'),
                    $this->getReference('customer_sidorova@gmail.com'),
                ],
            ],
        ];

        foreach ($reviews as $key => $data) {
            $review = new Review();
            $review->setCustomer($data['customer']);
            $review->setProduct($data['product']);
            $review->setText($data['text']);
            $review->setRate($data['rate']);
            $review->setCreatedAt($data['createdAt']);
            $review->setIsActive(true);

            foreach ($data['files'] as $path) {
                $reviewFile = new ReviewFile();
                $reviewFile->setReview($review);
                $reviewFile->setPath($path);

                $manager->persist($reviewFile);
            }

            /** @var Customer $customer */
            foreach ($data['likesCustomer'] as $customer) {
                $like = new ReviewLike();
                $like->setReview($review);
                $like->setCustomer($customer);

                $manager->persist($like);
            }

            $this->addReference('review_' . $key, $review);

            $manager->persist($review);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
