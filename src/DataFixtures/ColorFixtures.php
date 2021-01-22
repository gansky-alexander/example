<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ColorFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $colors = [
            '#FFE4C6' => 'Fair',
            '#FFF7EE' => 'Light',
            '#FFE9DE' => 'Medium',
            '#E7C4B9' => 'Tan',
            '#A25840' => 'Dark',
            '#5D3629' => 'Deep',
        ];

        foreach ($colors as $hex => $name) {
            $color = new Color();
            $color->setColor($hex);
            $color->setName($name);

            $this->addReference('color_' . $hex, $color);

            $manager->persist($color);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
