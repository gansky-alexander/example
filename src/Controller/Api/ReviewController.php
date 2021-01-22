<?php

namespace App\Controller\Api;

use App\Entity\Review;
use App\Model\BadgeModel;
use App\Model\ReviewModel;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Badge;

class ReviewController extends AbstractController
{
    /**
     * @Route("/review/{id}/like", methods={"POST"})
     *
     * @SWG\Response(
     *     response=404,
     *     description="Review is not found."
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Like review."
     * )
     *
     * @SWG\Tag(name="Review")
     * @Security(name="token")
     */
    public function likeReview(Request $request, ReviewModel $reviewModel)
    {
        /** @var Review $review */
        $review = $reviewModel->find($request->get('id'));

        if (!$review) {
            throw new NotFoundHttpException('Review is not found.');
        }

        $reviewModel->likeReview($review);

        return JsonResponse::fromJsonString('{}', 201);
    }

    /**
     * @Route("/review/{id}/unlike", methods={"POST"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="Unlike review."
     * )
     *
     * @SWG\Response(
     *     response=404,
     *     description="Review is not found."
     * )
     *
     * @SWG\Tag(name="Review")
     * @Security(name="token")
     */
    public function unlikeReview(Request $request, ReviewModel $reviewModel)
    {
        /** @var Review $review */
        $review = $reviewModel->find($request->get('id'));

        if (!$review) {
            throw new NotFoundHttpException('Review is not found.');
        }

        $reviewModel->unlikeReview($review);

        return JsonResponse::fromJsonString('{}', 201);
    }

}
