<?php

namespace App\DataFixtures;

use App\Entity\Color;
use App\Entity\SizeType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SizeTypeFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $sizeTypes = [
            [
                'name' => [
                    'en' => 'g',
                    'ru' => 'гр',
                ],
            ],
            [
                'name' => [
                    'en' => 'ml',
                    'ru' => 'мл',
                ],
            ],
        ];

        foreach ($sizeTypes as $data) {
            $sizeType = new SizeType();
            foreach ($data['name'] as $locale => $name) {
                $sizeType->translate($locale)->setName($name);
            }
            $sizeType->mergeNewTranslations();

            $this->addReference('sizeType_' . $data['name']['en'], $sizeType);

            $manager->persist($sizeType);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
