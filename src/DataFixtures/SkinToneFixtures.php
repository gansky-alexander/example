<?php


namespace App\DataFixtures;


use App\Entity\SkinTone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkinToneFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $skinTones = [
            [
                'name' => [
                    'en' => 'Fair',
                    'ru' => 'Натуральный',
                ],
                'color' => '#FFE4C6',
            ],
            [
                'name' => [
                    'en' => 'Light',
                    'ru' => 'Белый',
                ],
                'color' => '#FFF7EE',
            ],
            [
                'name' => [
                    'en' => 'Medium',
                    'ru' => 'Обычный',
                ],
                'color' => '#FFE9DE',
            ],
            [
                'name' => [
                    'en' => 'Tan',
                    'ru' => 'Загорелый',
                ],
                'color' => '#E7C4B9',
            ],
            [
                'name' => [
                    'en' => 'Dark',
                    'ru' => 'Темный',
                ],
                'color' => '#A25840',
            ],
            [
                'name' => [
                    'en' => 'Deep',
                    'ru' => 'Черный',
                ],
                'color' => '#5D3629',
            ],

        ];

        foreach ($skinTones as $data) {
            $skinTone = new SkinTone();
            $skinTone->setColor($data['color']);
            foreach($data['name'] as $locale => $name) {
                $skinTone->translate($locale)->setName($name);
            }
            $skinTone->mergeNewTranslations();

            $this->addReference('skinTone_' . $data['name']['en'], $skinTone);

            $manager->persist($skinTone);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
