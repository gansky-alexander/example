<?php

namespace App\Model;

use App\Entity\Badge;
use App\Entity\Order;
use App\Entity\OrderEntry;
use App\Entity\Product;
use App\Entity\ProductVariant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class OrderModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;
    protected $productModel;
    protected $security;
    protected $deliveryMethodModel;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductModel $productModel,
        DeliveryMethodModel $deliveryMethodModel,
        Security $security
    )
    {
        $this->entityManager = $entityManager;
        $this->productModel = $productModel;
        $this->security = $security;
        $this->deliveryMethodModel = $deliveryMethodModel;
    }

    public function getQuery($customer)
    {
        return $this->entityManager
            ->getRepository(Order::class)
            ->createQueryBuilder('o')
            ->where('o.customer = :customer')
            ->setParameter('customer', $customer);
    }

    public function createOrder($orderData)
    {
        $orderDataOriginal = $orderData;
        $order = new Order();
        $order->setStatus(Order::STATUS_NEW);
        $order->setCreatedAt(new \DateTime());
        $order->setCustomer($this->security->getUser());
        $deliveryMethod = $this->deliveryMethodModel->find($orderData['delivery_method']);
        if (!$deliveryMethod) {
            $orderData['status'] = 'error';
            $orderData['messages'][] = 'Delivery method is not valid';
        }
        $order->setDeliveryMethod($deliveryMethod);

        if (empty($orderData['shipment_address']) || !$orderData['shipment_address']) {
            $orderData['status'] = 'error';
            $orderData['messages'][] = 'Shipment address should not by empty.';
        } else {
            $order->setShipmentAddress($orderData['shipment_address']);
        }

        if (empty($orderData['shipment_address_2']) || !$orderData['shipment_address_2']) {
            $orderData['status'] = 'error';
            $orderData['messages'][] = 'Shipment address 2 should not by empty.';
        } else {
            $order->setShipmentAddress2($orderData['shipment_address_2']);
        }

        if (empty($orderData['shipment_city']) || !$orderData['shipment_city']) {
            $orderData['status'] = 'error';
            $orderData['messages'][] = 'Shipment city should not by empty.';
        } else {
            $order->setShipmentCity($orderData['shipment_city']);
        }

        if (empty($orderData['shipment_zip']) || !$orderData['shipment_zip']) {
            $orderData['status'] = 'error';
            $orderData['messages'][] = 'Shipment ZIP should not by empty.';
        } else {
            $order->setShipmentZip($orderData['shipment_zip']);
        }

        if (!empty($orderData['billing_address']) && $orderData['billing_address']) {
            $order->setBillingAddress($orderData['billing_address']);
        }
        if (!empty($orderData['billing_address_2']) && $orderData['billing_address_2']) {
            $order->setBillingAddress2($orderData['billing_address_2']);
        }
        if (!empty($orderData['billing_city']) && $orderData['billing_city']) {
            $order->setBillingCity($orderData['billing_city']);
        }
        if (!empty($orderData['billing_zip']) && $orderData['billing_zip']) {
            $order->setBillingZip($orderData['billing_zip']);
        }

        if (empty($orderData['is_shipment_same_as_billing']) && $orderData['is_shipment_same_as_billing'] !== false && $orderData['is_shipment_same_as_billing'] !== true) {
            $orderData['status'] = 'error';
            $orderData['messages'][] = 'You should specify if shipment is same as billing.';
        } else {
            $order->setShipmentZip(boolval($orderData['is_shipment_same_as_billing']));
        }

        foreach ($orderData['cart'] as $key => $cartEntry) {
            /** @var ProductVariant $variant */
            $variant = $this->productModel->findVariant($cartEntry['product']);

            if (!$variant || !$variant->getProduct()->getIsActive()) {
                $orderData['status'] = 'error';
                $orderData['messages'][] = 'Product is not active anymore';
                $orderData['cart'][$key]['message'] = 'Product is not active anymore';
                continue;
            }

            if ($variant->getStockAmount() < $cartEntry['quantity']) {
                $orderData['status'] = 'error';
                $orderData['messages'][] = 'It is not enough quantity in stock';
                $orderData['cart'][$key]['message'] = 'It is not enough quantity in stock';
                continue;
            }

            $orderEntry = new OrderEntry();
            $orderEntry->setOrder($order);
            $orderEntry->setPrice($variant->getPrice());
            $orderEntry->setProductVariant($variant);
            $orderEntry->setQuantity($cartEntry['quantity']);

            $variant->setStockAmount($variant->getStockAmount() - $cartEntry['quantity']);

            $this->entityManager->persist($variant);
            $this->entityManager->persist($orderEntry);
        }

        $this->entityManager->persist($order);

        if (json_encode($orderDataOriginal) != json_encode($orderData)) {
            return $orderData;
        }

        $this->entityManager->flush();

        $this->entityManager->refresh($order);
        return $order;
    }
}
