<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\OrderEntry;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Yokai\SonataWorkflow\Controller\WorkflowControllerTrait;

class OrderController extends CRUDController
{
    use WorkflowControllerTrait;

    protected function preApplyTransition($object, $transition)
    {
        switch ($transition) {
            case 'cancel':
                return $this->cancelOrder($object);
        }

        return null;
    }

    protected function cancelOrder(Order $object)
    {
        /** @var OrderEntry $orderEntry */
        foreach ($object->getEntries() as $orderEntry) {
            $productVariant = $orderEntry->getProductVariant();
            $productVariant->setStockAmount(
                $orderEntry->getQuantity() + $productVariant->getStockAmount()
            );

            $this->getDoctrine()->getManager()->persist($productVariant);
        }

        $this->getDoctrine()->getManager()->flush();

        return null;
    }
}
