<?php

namespace App\Controller\Api;

use App\Model\BoxModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Box;

class BoxController extends AbstractController
{
    /**
     * @Route("/box", methods={"GET"})
     *
     * @SWG\Get(
     *      summary="Get boxes.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get boxes.",
     *     @Model(type=Box::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Box")
     * @Security(name="token")
     */
    public function boxes(Request $request,
                          BoxModel $boxModel,
                          SerializerInterface $serializer)
    {
        $boxes = $boxModel->getQuery()->getQuery()->getResult();

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $boxes,
                'json',
                ['groups' => 'general']
            )
        );
    }

    /**
     * @Route("/box/{id}", methods={"GET"})
     *
     * @SWG\Get(
     *      summary="Get boxes.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get boxe.",
     *     @Model(type=Box::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Box")
     * @Security(name="token")
     */
    public function box(Request $request,
                        BoxModel $boxModel,
                        SerializerInterface $serializer)
    {
        $boxe = $boxModel->find($request->get('id'));

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $boxe,
                'json',
                ['groups' => 'general']
            )
        );
    }

    /**
     * @Route("/box/{id}/variant", methods={"POST"})
     *
     * @SWG\Post(
     *      summary="Get boxes.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get boxe.",
     *     @Model(type=Box::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Box")
     * @Security(name="token")
     */
    public function boxAddVariant(Request $request,
                                  BoxModel $boxModel,
                                  SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);
        $box = $boxModel->find($request->get('id'));
        $result = $boxModel->addVariant($box, $data);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'general']
            )
        );
    }

}
