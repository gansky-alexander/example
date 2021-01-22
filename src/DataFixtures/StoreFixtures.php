<?php

namespace App\DataFixtures;

use App\Entity\Store;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StoreFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $stores = [
            [
                'name' => 'Rouge',
                'image' => '/images/store/1.png',
            ],
            [
                'name' => 'Smooth',
                'image' => '/images/store/2.png',
            ],
            [
                'name' => 'Bloom',
                'image' => '/images/store/3.png',
            ],
            [
                'name' => 'Messy',
                'image' => '/images/store/4.png',
            ],
        ];

        foreach ($stores as $data) {
            $store = new Store();
            $store->setImage($data['image']);
            $store->setName($data['name']);

            $this->addReference('store_' . $data['name'], $store);

            $manager->persist($store);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
