<?php

namespace App\Model;

use App\Dto\ApiError;
use App\Entity\Customer;
use App\Entity\HairColor;
use App\Entity\SkinTone;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class UserModel
{
    use ErrorTrait;

    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var UserPasswordEncoderInterface */
    protected $passwordEncoder;
    /** @var ValidatorInterface */
    protected $validator;
    /** @var Security */
    protected $security;
    /** @var StoreModel */
    protected $storeModel;
    /** @var SkinToneModel */
    protected $skinToneModel;
    /** @var HairColorModel */
    protected $hairColorModel;
    /** @var CategoryModel */
    protected $categoryModel;
    /** @var BrandModel */
    protected $brandModel;
    protected $twig;
    protected $mailFrom;
    protected $mailer;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator,
        Security $security,
        StoreModel $storeModel,
        SkinToneModel $skinToneModel,
        HairColorModel $hairColorModel,
        CategoryModel $categoryModel,
        BrandModel $brandModel,
        Environment $twig,
        \Swift_Mailer $mailer,
        ParameterBagInterface $params
    )
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
        $this->security = $security;
        $this->storeModel = $storeModel;
        $this->skinToneModel = $skinToneModel;
        $this->hairColorModel = $hairColorModel;
        $this->categoryModel = $categoryModel;
        $this->brandModel = $brandModel;
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->mailFrom = $params->get('mailer_from');
    }

    public function register($email, $password, $birthDay)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);

        if (strlen($password) < 8 || !$uppercase || !$lowercase || !$number) {
            $apiError = new ApiError();

            $apiError->addError(
                'password',
                'Password is not valid, please use at least 8 symbols with upper cases, digits and special chars.'
            );

            return $apiError;
        }

        $customer = new Customer();

        $customer->setEmail($email);
        $customer->setPassword($this->passwordEncoder->encodePassword(
            $customer,
            $password
        ));
        $customer->setDateOfBirth(new \DateTime($birthDay));
        $customer->setIsEnabled(true);

        $errors = $this->validator->validate($customer, null, ['register']);

        if ($errors->count() > 0) {
            return $this->prepareError($errors);
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function login($email, $password)
    {
        /** @var Customer $customer */
        $customer = $this->entityManager->getRepository(Customer::class)
            ->findOneBy([
                'email' => $email,
            ]);

        if (!$customer || !$this->passwordEncoder->isPasswordValid($customer, $password) || !$customer->isEnabled()) {
            $error = new ApiError();
            $error->addError('email', 'Login or password are incorrect.');

            return $error;
        }

        $token = '';
        do {
            $token = TokenGenerator::generateRandomString($email);

            $exists = $this->entityManager->getRepository(Customer::class)
                ->findOneBy([
                    'token' => $token,
                ]);
        } while ($exists);

        $customer->setToken($token);
        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function updateProfile(Customer $customer, $data)
    {
        if (isset($data['shipment_address'])) {
            $customer->setShipmentAddress($data['shipment_address']);
        }

        if (isset($data['shipment_address_2'])) {
            $customer->setShipmentAddress2($data['shipment_address_2']);
        }

        if (isset($data['shipment_city'])) {
            $customer->setShipmentCity($data['shipment_city']);
        }

        if (isset($data['shipment_zip'])) {
            $customer->setShipmentZip($data['shipment_zip']);
        }

        if (isset($data['shipment_first_name'])) {
            $customer->setShipmentFirstName($data['shipment_first_name']);
        }

        if (isset($data['shipment_last_name'])) {
            $customer->setShipmentLastName($data['shipment_last_name']);
        }

        if (isset($data['is_shipment_same_as_billing'])) {
            $customer->setIsShipmentSameAsBilling($data['is_shipment_same_as_billing']);
        }

        if (isset($data['billing_address'])) {
            $customer->setBillingAddress($data['billing_address']);
        }

        if (isset($data['billing_address_2'])) {
            $customer->setBillingAddress2($data['billing_address_2']);
        }

        if (isset($data['billing_city'])) {
            $customer->setBillingCity($data['billing_city']);
        }

        if (isset($data['billing_zip'])) {
            $customer->setBillingZip($data['billing_zip']);
        }

        if ($data['date_of_birth'] != '') {
            $customer->setDateOfBirth(new \DateTime($data['date_of_birth']));
        } else {
            $customer->setDateOfBirth(null);
        }

        $customer->setName($data['name']);
        $customer->setGender($data['gender']);
        $customer->setEmail($data['email']);

        if (isset($data['use_as_default_address'])) {
            $customer->setUseAsDefaultAddress((bool)$data['use_as_default_address']);
        }

        if (isset($data['allow_notifications'])) {
            $customer->setAllowNotifications((bool)$data['allow_notifications']);
        }

        if (isset($data['allow_order_notifications'])) {
            $customer->setAllowOrderNotifications((bool)$data['allow_order_notifications']);
        }

        if (isset($data['allow_activity_notifications'])) {
            $customer->setAllowActivityNotifications((bool)$data['allow_activity_notifications']);
        }

        if (isset($data['allow_promotion_notifications'])) {
            $customer->setAllowsPromotionNotifications((bool)$data['allow_promotion_notifications']);
        }

        if (isset($data['allow_email_notifications'])) {
            $customer->setAllowEmailNotifications((bool)$data['allow_email_notifications']);
        }

        if ($data['password'] != '') {
            $customer->setPassword($this->passwordEncoder->encodePassword(
                $customer,
                $data['password']
            ));
        }

        $errors = $this->validator->validate($customer, null, ['updateProfile']);

        if ($errors->count() > 0) {
            return $this->prepareError($errors);
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function uploadAvatar(Customer $customer, $data)
    {
        $fileName = "avatar.jpg";
        $avatarPath = "/avatar/{$customer->getId()}";

        if (!is_dir('.' . $avatarPath)) {
            mkdir('.' . $avatarPath, 0777, true);
        }
        $customer->setAvatar($avatarPath . '/' . $fileName);

        $this->entityManager->persist($customer);

        file_put_contents('.' . $avatarPath . '/' . $fileName, base64_decode($data['avatar']));

        $this->entityManager->flush();
        return $customer;
    }

    public function updateOnboarding($content)
    {
        /** @var Store $store */
        $store = $this->storeModel->find($content['onboarding_store']);
        /** @var SkinTone $store */
        $skinTone = $this->skinToneModel->find($content['onboarding_skin_tone']);
        /** @var HairColor $hairColor */
        $hairColor = $this->hairColorModel->find($content['onboarding_hair_color']);
        $categories = $this->categoryModel->findMany($content['onboarding_categories']);
        $brands = $this->brandModel->findMany($content['onboarding_brands']);

        /** @var Customer $customer */
        $customer = $this->security->getUser();
        $customer->setOnboardingStore($store);
        $customer->setOnboardingQuestionAnswer($content['onboarding_question_answer']);
        $customer->setOnboardingSkinTone($skinTone);
        $customer->setOnboardingHairColor($hairColor);

        foreach ($customer->getOnboardingCategories() as $category) {
            if (!in_array($category->getId(), $content['onboarding_categories'])) {
                $customer->removeOnboardingCategory($category);
            }
        }
        foreach ($categories as $category) {
            $customer->addOnboardingCategory($category);
        }

        foreach ($customer->getOnboardingBrands() as $brand) {
            if (!in_array($brand->getId(), $content['onboarding_brands'])) {
                $customer->removeOnboardingBrand($brand);
            }
        }
        foreach ($brands as $brand) {
            $customer->addOnboardingBrand($brand);
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $this->entityManager->refresh($customer);

        return $customer;
    }

    public function sendForgotPasswordRequest($email)
    {
        /** @var Customer $customer */
        $customer = $this->getCustomerByEmail($email);

        if (!$customer) {
            throw new NotFoundHttpException('Customer does not exists or blocked.');
        }

        $resetPasswordToken = md5('reset_password' . $customer->getEmail() . date('ymdhis') . microtime());
        $customer->setToken(null);
        $customer->setResetPasswordToken($resetPasswordToken);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $mailBody = $this->twig->render('mails/forgot_password.html.twig', [
            'resetPasswordToken' => $resetPasswordToken,
        ]);

        $message = (new \Swift_Message())
            ->setFrom($this->mailFrom)
            ->setTo($customer->getEmail())
            ->setSubject('FYNE')
            ->setBody(
                $mailBody,
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function updatePassword($resetPasswordToken, $newPassword)
    {
        /** @var Customer $customer */
        $customer = $this->getCustomerByResetToken($resetPasswordToken);

        if (!$customer) {
            throw new NotFoundHttpException('Customer is not found or is blocked.');
        }

        $customer->setPassword($this->passwordEncoder->encodePassword(
            $customer,
            $newPassword
        ));

        $customer->setResetPasswordToken(null);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    public function getCustomerByEmail($email)
    {
        return $this->entityManager
            ->getRepository(Customer::class)
            ->createQueryBuilder('c')
            ->where('c.email = :email AND c.isEnabled = :isEnabled')
            ->setParameters([
                'email' => $email,
                'isEnabled' => true,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getCustomerByResetToken($resetPasswordToken)
    {
        return $this->entityManager
            ->getRepository(Customer::class)
            ->createQueryBuilder('c')
            ->where('c.resetPasswordToken = :resetPasswordToken AND c.isEnabled = :isEnabled')
            ->setParameters([
                'resetPasswordToken' => $resetPasswordToken,
                'isEnabled' => true,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
