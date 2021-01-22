<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Model\OrderModel;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", methods={"GET"})
     *
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     required=false,
     *     type="integer",
     *     default=1,
     *     description="The current page."
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     required=false,
     *     default=10,
     *     type="integer",
     *     description="Limit per page."
     * )
     *
     * @SWG\Get(
     *      summary="Get my orders.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get my orders.",
     *     @Model(type=Order::class, groups={"order"})
     * )
     *
     * @SWG\Tag(name="Order")
     * @Security(name="token")
     */
    public function myOrder(Request $request,
                            OrderModel $orderModel,
                            SerializerInterface $serializer,
                            PaginatorInterface $pager)
    {
        $query = $orderModel->getQuery($this->getUser());

        if ($request->query->getInt('limit', 10) != 0) {
            $result = $pager->paginate(
                $query,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 10)
            );
        } else {
            $result = $query->getQuery()->getResult();
        }

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'order']
            )
        );
    }

    /**
     * @Route("/order", methods={"POST"})
     *
     * @SWG\Post(
     *      summary="Create new order",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          type="json",
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="cart",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="object",
     *                      @SWG\Property(property="product", type="number", example="1"),
     *                      @SWG\Property(property="quantity", type="number", example="1"),
     *                  )
     *              ),
     *              @SWG\Property(property="delivery_method", type="integer", example="1"),
     *              @SWG\Property(property="shipment_address", type="string", example="Heroiv pratsi"),
     *              @SWG\Property(property="shipment_address_2", type="string", example="10"),
     *              @SWG\Property(property="shipment_city", type="string", example="Kharkiv"),
     *              @SWG\Property(property="shipment_zip", type="string", example="63000"),
     *              @SWG\Property(property="shipment_first_name", type="string", example="Alex"),
     *              @SWG\Property(property="shipment_last_name", type="string", example="Gansky"),
     *              @SWG\Property(property="billing_address", type="string", example="Heroiv pratsi"),
     *              @SWG\Property(property="billing_address_2", type="string", example="10"),
     *              @SWG\Property(property="billing_city", type="string", example="Kharkiv"),
     *              @SWG\Property(property="billing_zip", type="string", example="63000"),
     *              @SWG\Property(property="is_shipment_same_as_billing", type="boolean", example=false),
     *              @SWG\Property(property="vouchers",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="object",
     *                      @SWG\Property(property="id", type="number", example="2"),
     *                  )
     *              ),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Greated order.",
     *     @Model(type=Order::class, groups={"order"})
     * )
     *
     * @SWG\Tag(name="Order")
     * @Security(name="token")
     */
    public function createOrder(Request $request,
                                OrderModel $orderModel,
                                SerializerInterface $serializer)
    {
        $order = $orderModel->createOrder(json_decode($request->getContent(), true));

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $order,
                'json',
                ['groups' => 'order']
            )
        );
    }

}
