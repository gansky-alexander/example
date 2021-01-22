<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\HairColor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Brows',
                    'ru' => 'Брови',
                ],
                'image' => '/images/category/1.svg',
            ],
            [
                'name' => [
                    'en' => 'Lips',
                    'ru' => 'Губы',
                ],
                'image' => '/images/category/2.svg',
            ],
            [
                'name' => [
                    'en' => 'Nails',
                    'ru' => 'Ногти',
                ],
                'image' => '/images/category/3.svg',
            ],
            [
                'name' => [
                    'en' => 'Face',
                    'ru' => 'Лицо',
                ],
                'image' => '/images/category/4.svg',
            ],
            [
                'name' => [
                    'en' => 'Tools',
                    'ru' => 'Инструменты',
                ],
                'image' => '/images/category/5.svg',
            ],
            [
                'name' => [
                    'en' => 'Eyes',
                    'ru' => 'Глаза',
                ],
                'image' => '/images/category/6.svg',
            ],

            // children level 1
            [
                'name' => [
                    'en' => 'Eyeshadow',
                    'ru' => 'Тени для глаз',
                ],
                'parent' => 'Eyes',
            ],
            [
                'name' => [
                    'en' => 'Eyeliner',
                    'ru' => 'Карандаш для глаз',
                ],
                'parent' => 'Eyes',
            ],

            // children level 3
            [
                'name' => [
                    'en' => 'Neutrals',
                    'ru' => 'Нейтральные',
                ],
                'color' => '#FAEACB',
                'parent' => 'Eyeshadow',
            ],
            [
                'name' => [
                    'en' => 'Smokey',
                    'ru' => 'Пепельный',
                ],
                'color' => '#EEEEEE',
                'parent' => 'Eyeshadow',
            ],
            [
                'name' => [
                    'en' => 'Blues',
                    'ru' => 'Голубые',
                ],
                'color' => '#9CC0E7',
                'parent' => 'Eyeshadow',
            ],
            [
                'name' => [
                    'en' => 'Greens',
                    'ru' => 'Зеленые',
                ],
                'color' => '#A4E7A7',
                'parent' => 'Eyeshadow',
            ],
            [
                'name' => [
                    'en' => 'Plums',
                    'ru' => 'Сливовые',
                ],
                'color' => '#AF9CE7',
                'parent' => 'Eyeshadow',
            ],
            [
                'name' => [
                    'en' => 'Adventurous',
                    'ru' => 'Авантюрный',
                ],
                'color' => '#61D9DD',
                'parent' => 'Eyeshadow',
            ],
        ];

        foreach ($categories as $data) {
            $category = new Category();
            if (isset($data['image'])) {
                $category->setImage($data['image']);
            }

            if (isset($data['parent'])) {
                $category->setParent($this->getReference('category_' . $data['parent']));
            }

            if (isset($data['color'])) {
                $category->setColor($data['color']);
            }

            foreach ($data['name'] as $locale => $name) {
                $category->translate($locale)->setName($name);
            }
            $category->mergeNewTranslations();
            $this->addReference('category_' . $data['name']['en'], $category);

            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
