<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $brands = [
            [
                'name' => 'Clarins',
                'image' => '/images/brand/1.png',
            ],
            [
                'name' => 'Nars',
                'image' => '/images/brand/2.png',
            ],
            [
                'name' => 'e.l.f.',
                'image' => '/images/brand/3.png',
            ],
            [
                'name' => 'Glossier.',
                'image' => '/images/brand/4.png',
            ],
            [
                'name' => 'tonymoly',
                'image' => '/images/brand/5.png',
            ],
            [
                'name' => 'Loreal',
                'image' => '/images/brand/6.png',
            ],
            [
                'name' => 'NYX',
                'image' => '/images/brand/7.png',
            ],
            [
                'name' => 'Tom Ford',
                'image' => '/images/brand/8.png',
            ],
        ];

        foreach ($brands as $data) {
            $brand = new Brand();
            $brand->setImage($data['image']);
            $brand->setName($data['name']);

            $manager->persist($brand);

            $this->addReference('brand_' . $data['name'], $brand);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
