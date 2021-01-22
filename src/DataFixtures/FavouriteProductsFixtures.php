<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FavouriteProductsFixtures extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $favourites = [
            [
                'customer' => $this->getReference('customer_alexander.gansky@gmail.com'),
                'products' => [
                    $this->getReference('product_a'),
                    $this->getReference('product_1'),
                    $this->getReference('product_2'),
                    $this->getReference('product_3'),
                ],
            ],
            [
                'customer' => $this->getReference('customer_petrov@gmail.com'),
                'products' => [
                    $this->getReference('product_b'),
                    $this->getReference('product_4'),
                    $this->getReference('product_5'),
                    $this->getReference('product_6'),
                ],
            ],
            [
                'customer' => $this->getReference('customer_sidorova@gmail.com'),
                'products' => [
                    $this->getReference('product_c'),
                    $this->getReference('product_7'),
                    $this->getReference('product_8'),
                    $this->getReference('product_9'),
                ],
            ],
            [
                'customer' => $this->getReference('customer_ivanov@gmail.com'),
                'products' => [
                    $this->getReference('product_d'),
                    $this->getReference('product_10'),
                    $this->getReference('product_11'),
                    $this->getReference('product_12'),
                ],
            ],
        ];

        foreach ($favourites as $data) {
            /** @var Customer $customer */
            $customer = $data['customer'];
            $favouriteProducts = $data['products'];
            foreach ($favouriteProducts as $product) {
                $customer->addFavouriteProduct($product);
                $manager->persist($product);
            }
            $manager->persist($customer);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
