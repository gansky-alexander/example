<?php


namespace App\DataFixtures;


use App\Entity\HairColor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HairColorFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $hairColors = [
            [
                'name' => [
                    'en' => 'Black',
                    'ru' => 'Черные',
                ],
                'color' => '#000001',
            ],
            [
                'name' => [
                    'en' => 'Dark Brown',
                    'ru' => 'Темно коричневые',
                ],
                'color' => '#67051D',
            ],
            [
                'name' => [
                    'en' => 'Blonde',
                    'ru' => 'Блонд',
                ],
                'color' => '#FFEFC9',
            ],
            [
                'name' => [
                    'en' => 'Light Brown',
                    'ru' => 'Светло коричневые',
                ],
                'color' => '#997109',
            ],
            [
                'name' => [
                    'en' => 'Red',
                    'ru' => 'Красные',
                ],
                'color' => '#F54B4B',
            ],
            [
                'name' => [
                    'en' => 'Gray',
                    'ru' => 'Серые',
                ],
                'color' => '#B8B8B8',
            ],
            [
                'name' => [
                    'en' => 'Other',
                    'ru' => 'Другие',
                ],
                'color' => '#D062FF',
            ],
            [
                'name' => [
                    'en' => 'White',
                    'ru' => 'Белые',
                ],
                'color' => '#FAF8F8',
            ],
        ];

        foreach ($hairColors as $data) {
            $hairColor = new HairColor();
            $hairColor->setColor($data['color']);
            foreach ($data['name'] as $locale => $name) {
                $hairColor->translate($locale)->setName($name);
            }
            $hairColor->mergeNewTranslations();

            $this->addReference('hairColor_' . $data['name']['en'], $hairColor);

            $manager->persist($hairColor);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
