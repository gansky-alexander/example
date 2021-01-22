<?php


namespace App\DataFixtures;


use App\Entity\Badge;
use App\Entity\Category;
use App\Entity\HairColor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BadgeFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $badges = [
            [
                'name' => [
                    'en' => 'Sale',
                    'ru' => 'Скидка',
                ],
                'color' => '#ff0000',
            ],
            [
                'name' => [
                    'en' => 'Best seller',
                    'ru' => 'Топ продаж',
                ],
                'color' => '#00ff00',
                'sortOrder' => 2,
                'usedForSort' => true,
            ],
            [
                'name' => [
                    'en' => 'New arrivals',
                    'ru' => 'Новинка',
                ],
                'color' => '#0000ff',
                'sortOrder' => 10,
                'usedForSort' => true,
            ],
        ];

        foreach ($badges as $data) {
            $badge = new Badge();
            $badge->setColor($data['color']);
            if (isset($data['sortOrder'])) {
                $badge->setSortOrder($data['sortOrder']);
            }
            if (isset($data['usedForSort'])) {
                $badge->setUsedForSort($data['usedForSort']);
            }

            foreach ($data['name'] as $locale => $name) {
                $badge->translate($locale)->setName($name);
            }
            $badge->mergeNewTranslations();
            $this->addReference('badge_' . $data['name']['en'], $badge);

            $manager->persist($badge);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
