<?php

namespace App\Controller\Api;

use App\Model\SkinToneModel;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Entity\SkinTone;
use Symfony\Component\Serializer\SerializerInterface;


class SkinToneController extends AbstractController
{
    /**
     * @Route("/skin-tone", methods={"GET"})
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
     *      summary="Get all skin tones",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns all skin tones",
     *     @Model(type=SkinTone::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="SkinTone")
     * @Security(name="token")
     */
    public function skinTone(Request $request,
                             SkinToneModel $skinToneModel,
                             SerializerInterface $serializer,
                             PaginatorInterface $pager)
    {
        $query = $skinToneModel->getQuery();

        if($request->query->getInt('limit', 10) != 0) {
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
                ['groups' => 'general']
            )
        );
    }

}
