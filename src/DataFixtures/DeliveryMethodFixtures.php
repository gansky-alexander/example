<?php


namespace App\DataFixtures;


use App\Entity\Badge;
use App\Entity\Category;
use App\Entity\DeliveryMethod;
use App\Entity\HairColor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DeliveryMethodFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $deliveryMethods = [
            [
                'name' => [
                    'en' => 'Free',
                    'ru' => 'Бесплатно',
                ],
                'description' => [
                    'en' => 'Delivery 2-4 days',
                    'ru' => 'Доставка за 2-4 дня',
                ],
                'help' => [
                    'en' => '',
                    'ru' => '',
                ],
                'price' => 0,
            ],
            [
                'name' => [
                    'en' => 'Next Day',
                    'ru' => 'На следующий день',
                ],
                'help' => [
                    'en' => 'Help',
                    'ru' => 'Справка',
                ],
                'description' => [
                    'en' => 'Order before 11PM for Next Day Delivery',
                    'ru' => 'Заказ после 11 доставка на следующий день',
                ],
                'price' => 4.9,
            ],
        ];

        foreach ($deliveryMethods as $data) {
            $deliveryMethod = new DeliveryMethod();
            $deliveryMethod->setPrice($data['price']);

            foreach ($data['name'] as $locale => $name) {
                $deliveryMethod->translate($locale)->setName($name);
            }

            foreach ($data['help'] as $locale => $help) {
                $deliveryMethod->translate($locale)->setHelp($help);
            }

            foreach ($data['description'] as $locale => $description) {
                $deliveryMethod->translate($locale)->setDescription($description);
            }

            $deliveryMethod->mergeNewTranslations();
            $this->addReference('delivery_method_' . $data['name']['en'], $deliveryMethod);

            $manager->persist($deliveryMethod);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
