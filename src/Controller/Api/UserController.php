<?php

namespace App\Controller\Api;

use App\Model\UserModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Entity\Customer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", methods={"POST"})
     *
     * @SWG\Post(
     *      summary="Register new user",
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
     *              @SWG\Property(property="email", type="string", example="alexander.gansky@gmail.com"),
     *              @SWG\Property(property="password", type="string", example="12345678"),
     *              @SWG\Property(property="birth_day", type="date", example="2020-01-01"),
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns registered user",
     *     @Model(type=Customer::class, groups={"profile"})
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function register(Request $request,
                             UserModel $userModel,
                             SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);

        $result = $userModel->register($data['email'], $data['password'], $data['birth_day']);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'profile']
            )
        );
    }

    /**
     * @Route("/login", methods={"POST"})
     *
     * @SWG\Post(
     *     summary="Login action",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="JSON Payload",
     *         required=true,
     *         type="json",
     *         format="application/json",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="email", type="string", example="alexander.gansky@gmail.com"),
     *             @SWG\Property(property="password", type="string", example="12345678"),
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns logged in user",
     *     @Model(type=Customer::class, groups={"profile"})
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="User send wrong credentials"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function login(Request $request,
                          UserModel $userModel,
                          SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);

        $result = $userModel->login($data['email'], $data['password']);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'profile']
            )
        );
    }

    /**
     * @Route("/profile", methods={"GET"})
     *
     * @SWG\Get (
     *     summary="Get user profile",
     *     consumes={"application/json"},
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns logged in users profile",
     *     @Model(type=Customer::class, groups={"profile"})
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="User send wrong credentials"
     * )
     *
     * @SWG\Tag(name="User")
     * @Security(name="token")
     */
    public function profile(Request $request,
                            UserModel $userModel,
                            SerializerInterface $serializer)
    {
        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $this->getUser(),
                'json',
                ['groups' => 'profile']
            )
        );
    }

    /**
     * @Route("/profile", methods={"PUT"})
     *
     * @SWG\Put(
     *     summary="Update user's profile",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="JSON Payload",
     *         required=true,
     *         type="json",
     *         format="application/json",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="name", type="string", example="Alex Gansky"),
     *             @SWG\Property(property="gender", type="string", example="male"),
     *             @SWG\Property(property="date_of_birth", type="date", example="1989-04-09"),
     *             @SWG\Property(property="password", type="string", example="12345678"),
     *             @SWG\Property(property="email", type="string", example="alexander.gansky@gmail.com"),
     *             @SWG\Property(property="allow_notifications", type="boolean", example="true"),
     *             @SWG\Property(property="allow_order_notifications", type="boolean", example="true"),
     *             @SWG\Property(property="allow_promotion_notifications", type="boolean", example="true"),
     *             @SWG\Property(property="allow_activity_notifications", type="boolean", example="true"),
     *             @SWG\Property(property="shipment_address", type="string"),
     *             @SWG\Property(property="shipment_address_2", type="string"),
     *             @SWG\Property(property="shipment_city", type="string"),
     *             @SWG\Property(property="shipment_zip", type="string"),
     *             @SWG\Property(property="is_shipment_same_as_billing", type="bollean"),
     *             @SWG\Property(property="billing_address", type="string"),
     *             @SWG\Property(property="billing_address_2", type="string"),
     *             @SWG\Property(property="billing_city", type="string"),
     *             @SWG\Property(property="billing_zip", type="string")
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns logged in users profile",
     *     @Model(type=Customer::class, groups={"profile"})
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="User send wrong credentials"
     * )
     *
     * @SWG\Tag(name="User")
     * @Security(name="token")
     */
    public function profileUpdate(Request $request,
                                  UserModel $userModel,
                                  SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);

        $result = $userModel->updateProfile($this->getUser(), $data);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'profile']
            )
        );
    }

    /**
     * @Route("/avatar", methods={"POST"})
     *
     * @SWG\Post(
     *     summary="Update user's profile",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="JSON Payload",
     *         required=true,
     *         type="json",
     *         format="application/json",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="avatar", type="string", example="BASE64 encoded file"),
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns logged in users profile",
     *     @Model(type=Customer::class, groups={"profile"})
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="User send wrong credentials"
     * )
     *
     * @SWG\Tag(name="User")
     * @Security(name="token")
     */
    public function avatar(Request $request,
                           UserModel $userModel,
                           SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);

        $result = $userModel->uploadAvatar($this->getUser(), $data);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $result,
                'json',
                ['groups' => 'profile']
            )
        );
    }

    /**
     * @Route("/onboarding", methods={"GET"})
     *
     * @SWG\Get (
     *     summary="Get user profile",
     *     consumes={"application/json"},
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns logged in users profile",
     *     @Model(type=Customer::class, groups={"onboarding"})
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="User send wrong credentials"
     * )
     *
     * @SWG\Tag(name="User")
     * @Security(name="token")
     */
    public function onboarding(Request $request,
                               UserModel $userModel,
                               SerializerInterface $serializer)
    {
        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $this->getUser(),
                'json',
                ['groups' => 'onboarding']
            )
        );
    }

    /**
     * @Route("/onboarding", methods={"PUT"})
     *
     * @SWG\Put(
     *     summary="Update user's profile",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="JSON Payload",
     *         required=true,
     *         type="json",
     *         format="application/json",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="onboarding_categories",
     *                 type="array",
     *                 @SWG\Items(
     *                      type="integer",
     *                      example="1",
     *                  )
     *             ),
     *             @SWG\Property(
     *                 property="onboarding_brands",
     *                 type="array",
     *                 @SWG\Items(
     *                      type="integer",
     *                      example="1",
     *                  )
     *             ),
     *             @SWG\Property(property="onboarding_skin_tone", type="integer"),
     *             @SWG\Property(property="onboarding_question_answer", type="string"),
     *             @SWG\Property(property="onboarding_hair_color", type="integer"),
     *             @SWG\Property(property="onboarding_store", type="integer")
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns logged in users profile",
     *     @Model(type=Customer::class, groups={"onboarding"})
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="User send wrong credentials"
     * )
     *
     * @SWG\Tag(name="User")
     * @Security(name="token")
     */
    public function updateOnboarding(Request $request,
                                     UserModel $userModel,
                                     SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);

        $customer = $userModel->updateOnboarding($content);

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $customer,
                'json',
                ['groups' => 'onboarding']
            )
        );
    }

    /**
     * @Route("/forgot-password/{email}", methods={"GET"})
     *
     * @SWG\Get(
     *     summary="Get forgot password email.",
     *     consumes={"application/json"},
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns empty array"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function sendForgotPassword(Request $request,
                                       UserModel $userModel,
                                       SerializerInterface $serializer)
    {
        $userModel->sendForgotPasswordRequest($request->get('email'));

        return new JsonResponse([]);
    }

    /**
     * @Route("/forgot-password", methods={"POST"})
     *
     * @SWG\Post(
     *     summary="Update users password",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="JSON Payload",
     *         required=true,
     *         type="json",
     *         format="application/json",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="password", type="string"),
     *             @SWG\Property(property="reset_password_token", type="string")
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns empty array"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function updatePassword(Request $request,
                                   UserModel $userModel,
                                   SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);
        $userModel->updatePassword($data['reset_password_token'], $data['password']);

        return new JsonResponse([]);
    }
}
