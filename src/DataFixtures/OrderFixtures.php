<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Order;
use App\Entity\OrderEntry;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductVariant;
use App\Entity\SonataMediaMedia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;

class OrderFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $orders = [
            [
                'created_at' => new \DateTime('2020-01-02'),
                'customer' => $this->getReference('customer_alexander.gansky@gmail.com'),
                'status' => 'new',
                'delivery_method' => $this->getReference('delivery_method_Free'),
                'shipmentAddress' => 'Washington street',
                'shipmentAddress2' => '2',
                'shipmentCity' => 'New York',
                'shipmentZip' => '12345',
                'isShipmentSameAsBilling' => false,
                'billingAddress' => 'Washington street',
                'billingAddress2' => '2',
                'billingCity' => 'New York',
                'billingZip' => '12345',
                'entries' => [
                    [
                        'quantity' => 1,
                        'price' => 20,
                        'product_variant' => $this->getReference('product_variant_D006'),
                    ],
                ],
            ],
            [
                'created_at' => new \DateTime('2020-01-03'),
                'customer' => $this->getReference('customer_petrov@gmail.com'),
                'status' => 'canceled',
                'delivery_method' => $this->getReference('delivery_method_Free'),
                'shipmentAddress' => 'Ukrainian street',
                'shipmentAddress2' => '25',
                'shipmentCity' => 'Chicago',
                'shipmentZip' => '84927',
                'isShipmentSameAsBilling' => true,
                'billingAddress' => '',
                'billingAddress2' => '',
                'billingCity' => '',
                'billingZip' => '',
                'entries' => [
                    [
                        'quantity' => 1,
                        'price' => 20,
                        'product_variant' => $this->getReference('product_variant_D006'),
                    ],
                ],
            ],
            [
                'created_at' => new \DateTime('2020-01-04'),
                'customer' => $this->getReference('customer_sidorova@gmail.com'),
                'status' => 'in_progress',
                'delivery_method' => $this->getReference('delivery_method_Free'),
                'shipmentAddress' => 'First street',
                'shipmentAddress2' => '143',
                'shipmentCity' => 'LA',
                'shipmentZip' => '54523',
                'isShipmentSameAsBilling' => true,
                'billingAddress' => '',
                'billingAddress2' => '',
                'billingCity' => '',
                'billingZip' => '',
                'entries' => [
                    [
                        'quantity' => 2,
                        'price' => 20,
                        'product_variant' => $this->getReference('product_variant_A001'),
                    ],
                    [
                        'quantity' => 1,
                        'price' => 25,
                        'product_variant' => $this->getReference('product_variant_B002'),
                    ],
                    [
                        'quantity' => 4,
                        'price' => 21,
                        'product_variant' => $this->getReference('product_variant_C003'),
                    ],
                    [
                        'quantity' => 5,
                        'price' => 12,
                        'product_variant' => $this->getReference('product_variant_D004'),
                    ],
                ],
            ],
        ];

        foreach ($orders as $data) {
            $order = new Order();

            $order->setCreatedAt($data['created_at']);
            $order->setCustomer($data['customer']);
            $order->setStatus($data['status']);
            $order->setDeliveryMethod($data['delivery_method']);

            $order->setShipmentAddress($data['shipmentAddress']);
            $order->setShipmentAddress2($data['shipmentAddress2']);
            $order->setShipmentCity($data['shipmentCity']);
            $order->setShipmentZip($data['shipmentZip']);
            $order->setIsShipmentSameAsBilling($data['isShipmentSameAsBilling']);
            $order->setBillingAddress($data['billingAddress']);
            $order->setBillingAddress2($data['billingAddress2']);
            $order->setBillingCity($data['billingCity']);
            $order->setBillingZip($data['billingZip']);

            foreach ($data['entries'] as $entryData) {
                $orderEntry = new OrderEntry();
                $orderEntry->setOrder($order);
                $orderEntry->setPrice($entryData['price']);
                $orderEntry->setQuantity($entryData['quantity']);
                $orderEntry->setProductVariant($entryData['product_variant']);

                $manager->persist($orderEntry);
            }

            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
