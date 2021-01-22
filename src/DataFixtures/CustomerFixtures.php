<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFixtures extends Fixture implements OrderedFixtureInterface
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $customers = [
            [
                'email' => 'alexander.gansky@gmail.com',
                'name' => 'Alex Gansky',
                'token' => 'i67two4tora8w67to48q643tgo86rtoq86t4',
                'date_of_birth' => '1989-04-09',
                'gender' => Customer::SEX_MALE,
                'subscription_ends' => '2020-12-31',
                'avatar' => '/avatar/test/avatar.jpg',
                'password' => '12345678',
                'onboardingCategories' => [
                    $this->getReference('category_Greens'),
                    $this->getReference('category_Smokey'),
                    $this->getReference('category_Neutrals'),
                ],
                'onboardingSkinTone' => $this->getReference('skinTone_Tan'),
                'onboardingBrands' => [
                    $this->getReference('brand_Clarins'),
                    $this->getReference('brand_Glossier.'),
                    $this->getReference('brand_Loreal'),
                ],
                'onboardingQuestionAnswer' => 'Very comfortable',
                'onboardingHairColor' => $this->getReference('hairColor_Red'),
                'onboardingStore' => $this->getReference('store_Bloom'),
            ],
            [
                'email' => 'petrov@gmail.com',
                'name' => 'Petr Petrov',
                'token' => '6i76utruijytrufj5ytru5yjtru7jytrf',
                'date_of_birth' => '1990-01-01',
                'gender' => Customer::SEX_MALE,
                'subscription_ends' => '2020-12-31',
                'avatar' => '/avatar/test/avatar.jpg',
                'password' => '12345678',
                'onboardingCategories' => [
                    $this->getReference('category_Greens'),
                    $this->getReference('category_Smokey'),
                    $this->getReference('category_Neutrals'),
                ],
                'onboardingSkinTone' => $this->getReference('skinTone_Tan'),
                'onboardingBrands' => [
                    $this->getReference('brand_Clarins'),
                    $this->getReference('brand_Glossier.'),
                    $this->getReference('brand_Loreal'),
                ],
                'onboardingQuestionAnswer' => 'Very comfortable',
                'onboardingHairColor' => $this->getReference('hairColor_Red'),
                'onboardingStore' => $this->getReference('store_Bloom'),
            ],
            [
                'email' => 'sidorova@gmail.com',
                'name' => 'Sidorova',
                'token' => '7uy5trfuyrtdi75ytriytrdiyjrerduy5jrd',
                'date_of_birth' => '1991-01-01',
                'gender' => Customer::SEX_FEMALE,
                'subscription_ends' => '2020-12-31',
                'avatar' => '/avatar/test/avatar.jpg',
                'password' => '12345678',
                'onboardingCategories' => [
                    $this->getReference('category_Greens'),
                    $this->getReference('category_Smokey'),
                    $this->getReference('category_Neutrals'),
                ],
                'onboardingSkinTone' => $this->getReference('skinTone_Tan'),
                'onboardingBrands' => [
                    $this->getReference('brand_Clarins'),
                    $this->getReference('brand_Glossier.'),
                    $this->getReference('brand_Loreal'),
                ],
                'onboardingQuestionAnswer' => 'Very comfortable',
                'onboardingHairColor' => $this->getReference('hairColor_Red'),
                'onboardingStore' => $this->getReference('store_Bloom'),
            ],
            [
                'email' => 'ivanov@gmail.com',
                'name' => 'Ivan Ivanov',
                'token' => '75yrte9i75etri75teri75utrftu',
                'date_of_birth' => '1992-01-01',
                'gender' => Customer::SEX_MALE,
                'subscription_ends' => '2020-12-31',
                'avatar' => '/avatar/test/avatar.jpg',
                'password' => '12345678',
                'onboardingCategories' => [
                    $this->getReference('category_Greens'),
                    $this->getReference('category_Smokey'),
                    $this->getReference('category_Neutrals'),
                ],
                'onboardingSkinTone' => $this->getReference('skinTone_Tan'),
                'onboardingBrands' => [
                    $this->getReference('brand_Clarins'),
                    $this->getReference('brand_Glossier.'),
                    $this->getReference('brand_Loreal'),
                ],
                'onboardingQuestionAnswer' => 'Very comfortable',
                'onboardingHairColor' => $this->getReference('hairColor_Red'),
                'onboardingStore' => $this->getReference('store_Bloom'),
            ],
        ];

        foreach ($customers as $data) {
            $customer = new Customer();
            $customer->setEmail($data['email']);
            $customer->setName($data['name']);
            $customer->setToken($data['token']);
            $customer->setDateOfBirth(new \DateTime($data['date_of_birth']));
            $customer->setGender($data['gender']);
            $customer->setSubscriptionEnd(new \DateTime($data['subscription_ends']));
            $customer->setAvatar($data['avatar']);
            $customer->setPassword($this->passwordEncoder->encodePassword(
                $customer,
                $data['password']
            ));

            $customer->setOnboardingHairColor($data['onboardingHairColor']);
            $customer->setOnboardingQuestionAnswer($data['onboardingQuestionAnswer']);
            $customer->setOnboardingSkinTone($data['onboardingSkinTone']);
            $customer->setOnboardingStore($data['onboardingStore']);

            foreach ($data['onboardingCategories'] as $category) {
                $customer->addOnboardingCategory($category);
            }

            foreach ($data['onboardingBrands'] as $brand) {
                $customer->addOnboardingBrand($brand);
            }

            $this->addReference('customer_' . $data['email'], $customer);

            $manager->persist($customer);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
