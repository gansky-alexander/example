<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Entity\Review;
use App\Model\ProductModel;
use App\Model\ProductReviewModel;
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


class ProductController extends AbstractController
{
    /**
     * @Route("/product/reviews", methods={"GET"})
     *
     * @SWG\Get(
     *      summary="Get products reviews.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get products reviews.",
     *     @Model(type=Review::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Review")
     * @Security(name="token")
     */
    public function productsReviews(Request $request,
                                    ProductReviewModel $productReviewModel,
                                    SerializerInterface $serializer)
    {
        $reviews = $productReviewModel->getReviews();

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $reviews,
                'json',
                ['groups' => 'general']
            )
        );
    }

    /**
     * @Route("/product/reviews", methods={"POST"})
     *
     * @SWG\Post(
     *      summary="Add product variant review",
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
     *              @SWG\Property(property="product", type="integer", example="1"),
     *              @SWG\Property(property="text", type="string", example="Review text example"),
     *              @SWG\Property(property="rate", type="float", example="4.5"),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Get products reviews.",
     *     @Model(type=Review::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Review")
     * @Security(name="token")
     */
    public function addProductsReview(Request $request,
                                      ProductReviewModel $productReviewModel,
                                      SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);

        $result = $productReviewModel->addProductReview($content);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'general']
            ),
            201
        );
    }

    /**
     * @Route("/product/reviews", methods={"PUT"})
     *
     * @SWG\Put(
     *      summary="Update product variant review",
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
     *              @SWG\Property(property="review_id", type="integer", example="1"),
     *              @SWG\Property(property="text", type="string", example="Review text example"),
     *              @SWG\Property(property="rate", type="float", example="4.5"),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Get products reviews.",
     *     @Model(type=Review::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Review")
     * @Security(name="token")
     */
    public function updateProductsReview(Request $request,
                                      ProductReviewModel $productReviewModel,
                                      SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);

        $result = $productReviewModel->updateProductReview($content);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'general']
            ),
            201
        );
    }

    /**
     * @Route("/product/reviews/file", methods={"POST"})
     *
     * @SWG\Post(
     *      summary="Add product variant review",
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
     *              @SWG\Property(property="review_id", type="integer", example="1"),
     *              @SWG\Property(property="content", type="string", example="BASE64 content of image"),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Get products reviews.",
     *     @Model(type=Review::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Review")
     * @Security(name="token")
     */
    public function addProductsReviewFile(Request $request,
                                      ProductReviewModel $productReviewModel,
                                      SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);

        $result = $productReviewModel->addProductReviewFile($content);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'general']
            ),
            201
        );
    }

    /**
     * @Route("/product/reviews", methods={"DELETE"})
     *
     * @SWG\Delete(
     *      summary="Remove product reviews",
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
     *              @SWG\Property(property="review_id", type="integer", example="1"),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=202,
     *     description="Get products reviews.",
     *     @Model(type=Review::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Review")
     * @Security(name="token")
     */
    public function removeProductReviews(Request $request,
                                         ProductReviewModel $productReviewModel,
                                         SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);

        $review = $productReviewModel->find($content['review_id']);

        if(!$review) {
            throw new NotFoundHttpException('Review does not exists.');
        }

        $productReviewModel->remove($review);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $productReviewModel->getReviews(),
                'json',
                ['groups' => 'general']
            ),
            202
        );
    }

    /**
     * @Route("/product/favourites", methods={"GET"})
     *
     * @SWG\Get(
     *      summary="Get favourite products.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get favourite products.",
     *     @Model(type=Product::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Product")
     * @Security(name="token")
     */
    public function favouriteProducts(Request $request,
                                      ProductModel $productModel,
                                      SerializerInterface $serializer)
    {
        $products = $productModel->getFavourites();

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $products,
                'json',
                ['groups' => 'general']
            )
        );
    }

    /**
     * @Route("/product/favourites", methods={"POST"})
     *
     * @SWG\Post(
     *      summary="Add product to favourite",
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
     *              @SWG\Property(property="product", type="integer", example="1"),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Get favourite products.",
     *     @Model(type=Product::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Product")
     * @Security(name="token")
     */
    public function addFavouriteProducts(Request $request,
                                         ProductModel $productModel,
                                         SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);

        $product = $productModel->find($content['product']);

        $productModel->addFavourites($product);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $productModel->getFavourites(),
                'json',
                ['groups' => 'general']
            ),
            201
        );
    }

    /**
     * @Route("/product/favourites", methods={"DELETE"})
     *
     * @SWG\Delete(
     *      summary="Add product to favourite",
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
     *              @SWG\Property(property="product", type="integer", example="1"),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=202,
     *     description="Get favourite products.",
     *     @Model(type=Product::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Product")
     * @Security(name="token")
     */
    public function removeFavouriteProducts(Request $request,
                                            ProductModel $productModel,
                                            SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);

        $product = $productModel->find($content['product']);

        $productModel->removeFavourites($product);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $productModel->getFavourites(),
                'json',
                ['groups' => 'general']
            ),
            202
        );
    }

    /**
     * @Route("/product", methods={"GET"})
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
     *     name="search",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="Search query for products."
     * )
     * @SWG\Parameter(
     *     name="badges",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="Filter by badges."
     * )
     * @SWG\Parameter(
     *     name="categories",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="Filter by categories."
     * )
     * @SWG\Parameter(
     *     name="brands",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="Filter by brands."
     * )
     * @SWG\Parameter(
     *     name="ids",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="Filter by products ID's."
     * )
     * @SWG\Parameter(
     *     name="price-from",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="number",
     *     description="Filter lower price products."
     * )
     * @SWG\Parameter(
     *     name="price-to",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="number",
     *     description="Filter upper price products."
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="Order the products.",
     *     enum={"price-asc", "price-desc", "badge"}
     * )
     * @SWG\Parameter(
     *     name="badge-order-value",
     *     in="query",
     *     required=false,
     *     default="",
     *     type="string",
     *     description="Badge to order the products. Is required and will be used only of 'sort' parameters equals to 'badge'."
     * )
     *
     * @SWG\Get(
     *      summary="Get products.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get products.",
     *     @Model(type=Product::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Product")
     * @Security(name="token")
     */
    public function products(Request $request,
                             ProductModel $productModel,
                             SerializerInterface $serializer,
                             PaginatorInterface $pager)
    {
        $usedForBox = strtolower($request->get('used-for-box', ''));
        $usedForBox = $usedForBox === 'true' ? true : ($usedForBox === 'false' ? false : '');
        $query = $productModel->getQuery(
            $request->get('search', ''),
            $request->get('badges', ''),
            $request->get('categories', ''),
            $request->get('brands', ''),
            $request->get('ids', ''),
            $request->get('price-from', ''),
            $request->get('price-to', ''),
            $usedForBox,
            $request->get('order', ''),
            $request->get('badge-order-value', '')
        );

        $result = $pager->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10),
            ['wrap-queries' => true]
        );

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'general']
            )
        );
    }

    /**
     * @Route("/product/{id}", methods={"GET"})
     *
     * @SWG\Get(
     *      summary="Get product by ID.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get products.",
     *     @Model(type=Product::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Product")
     * @Security(name="token")
     */
    public function product(Request $request,
                            ProductModel $productModel,
                            SerializerInterface $serializer,
                            PaginatorInterface $pager)
    {
        $product = $productModel->find($request->get('id'));

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $product,
                'json',
                ['groups' => 'general']
            )
        );
    }

    /**
     * @Route("/product/{id}/reviews", methods={"GET"})
     *
     * @SWG\Get(
     *      summary="Get product reviews.",
     *      consumes={"application/json"},
     *      produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get product reviews.",
     *     @Model(type=Review::class, groups={"general"})
     * )
     *
     * @SWG\Tag(name="Product")
     * @Security(name="token")
     */
    public function productReviews(Request $request,
                            ProductModel $productModel,
                            SerializerInterface $serializer,
                            PaginatorInterface $pager)
    {
        $product = $productModel->findActiveReviewsByProductId($request->get('id'));

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $product,
                'json',
                ['groups' => 'general']
            )
        );
    }

}
