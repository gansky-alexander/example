<?php

namespace App\Controller\Api;

use App\Model\CategoryModel;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", methods={"GET"})
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
     * @SWG\Parameter(
     *     name="parent",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="integer",
     *     description="ID of parent category."
     * )
     *
     * @SWG\Get(
     *      summary="Get categories.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get categories.",
     *     @Model(type=Category::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Category")
     * @Security(name="token")
     */
    public function category(Request $request,
                             CategoryModel $categoryModel,
                             SerializerInterface $serializer,
                             PaginatorInterface $pager)
    {
        $parent = $categoryModel->find($request->get('parent'));
        $query = $categoryModel->getQuery($parent);

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
