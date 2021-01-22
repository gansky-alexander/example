<?php

namespace App\Controller\Api;

use App\Model\BadgeModel;
use App\Model\BlogModel;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Blog;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", methods={"GET"})
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
     *     name="tags",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="IDs of tags to filter blog posts."
     * )
     * @SWG\Parameter(
     *     name="is-for-you",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="boolean",
     *     description="Filter by is_for_you."
     * )
     * @SWG\Parameter(
     *     name="is-popular",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="boolean",
     *     description="Filter by is_popular."
     * )
     *
     * @SWG\Get(
     *      summary="Get blog posts.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get blog posts.",
     *     @Model(type=Blog::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Blog")
     * @Security(name="token")
     */
    public function blog(Request $request,
                          BlogModel $blogModel,
                          SerializerInterface $serializer,
                          PaginatorInterface $pager)
    {
        $query = $blogModel->getQuery(
            $request->get('tags', ''),
            $request->get('is-for-you', ''),
            $request->get('is-popular', '')
        );

        $result = $pager->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'general']
            )
        );
    }

}
