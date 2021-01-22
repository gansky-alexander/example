<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 *
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="This email is already in use.",
 *     groups={"updateProfile", "register"}
 * )
 */
class Customer implements UserInterface
{
    const SEX_MALE = 'male';
    const SEX_FEMALE = 'female';
    const SEX_HIDDEN = 'hidden';
    const GENDERS = [self::SEX_FEMALE, self::SEX_MALE, self::SEX_HIDDEN];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(
     *     message = "The email can not be blank.",
     *     groups={"updateProfile", "register"}
     * )
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     groups={"updateProfile", "register"}
     * )
     *
     * @SWG\Property(
     *     type="string",
     *     description="The email of the customer.",
     *     maxLength=255,
     *     property="email"
     * )
     * @Groups({"profile"})
     * @SerializedName("email")
     *
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(
     *     message = "The name can not be blank.",
     *     groups={"updateProfile"}
     * )
     *
     * @SWG\Property(
     *     type="string",
     *     description="Customers name.",
     *     maxLength=255,
     *     property="name"
     * )
     *
     * @Groups({"profile", "general"})
     * @SerializedName("name")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @Assert\Choice(
     *     choices=Customer::GENDERS,
     *     message="Choose a correct gender.",
     *     groups={"updateProfile"}
     * )
     *
     * @SWG\Property(
     *     type="string",
     *     description="Customers gender.",
     *     maxLength=255,
     *     property="gender"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("gender")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @SWG\Property(
     *     type="string",
     *     description="URI to customers avatar.",
     *     maxLength=255,
     *     property="avatar"
     * )
     *
     * @Groups({"profile", "general"})
     * @SerializedName("avatar")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @SWG\Property(
     *     type="string",
     *     description="Customers date of birth.",
     *     maxLength=255,
     *     property="date_of_birth"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("date_of_birth")
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @SWG\Property(
     *     type="string",
     *     description="End of the subcription.",
     *     maxLength=255,
     *     property="subscription_end"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("subscription_end")
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $subscriptionEnd;

    /**
     * @SWG\Property(
     *     type="string",
     *     description="API token.",
     *     maxLength=255,
     *     property="token"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("token")
     *
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnabled;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class)
     */
    private $favouriteProducts;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SWG\Property(
     *     type="boolean",
     *     description="Is customer allow notifiations.",
     *     property="allow_notifications"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("allow_notifications")
     */
    private $allowNotifications;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SWG\Property(
     *     type="boolean",
     *     description="Is customer allow order notifications.",
     *     property="allow_order_notifications"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("allow_order_notifications")
     */
    private $allowOrderNotifications;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SWG\Property(
     *     type="boolean",
     *     description="Is customer allow promotion notifications.",
     *     property="allow_promotion_notifications"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("allow_promotion_notifications")
     */
    private $allowsPromotionNotifications;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SWG\Property(
     *     type="boolean",
     *     description="Is customer allow activity notifications.",
     *     property="allow_activity_notifications"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("allow_activity_notifications")
     */
    private $allowActivityNotifications;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SWG\Property(
     *     type="boolean",
     *     description="Is customer allow email notifications.",
     *     property="allow_email_notifications"
     * )
     *
     * @Groups({"profile"})
     * @SerializedName("allow_email_notifications")
     */
    private $allowEmailNotifications;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class)
     *
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         ref=@Model(type=Category::class)
     *     ),
     *     property="onboarding_categories"
     * )
     * @Groups({"onboarding"})
     * @SerializedName("onboarding_categories")
     */
    private $onboardingCategories;

    /**
     * @ORM\ManyToOne(targetEntity=SkinTone::class)
     *
     * @SWG\Property(ref=@Model(type=SkinTone::class))
     * @Groups({"onboarding"})
     * @SerializedName("onboarding_skin_tone")
     */
    private $onboardingSkinTone;

    /**
     * @ORM\ManyToMany(targetEntity=Brand::class)
     *
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         ref=@Model(type=Brand::class)
     *     ),
     *     property="onboarding_brands"
     * )
     * @Groups({"onboarding"})
     * @SerializedName("onboarding_brands")
     */
    private $onboardingBrands;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="onboarding"
     * )
     * @Groups({"onboarding"})
     * @SerializedName("onboarding_question_answer")
     */
    private $onboardingQuestionAnswer;

    /**
     * @ORM\ManyToOne(targetEntity=HairColor::class)
     *
     * @SWG\Property(ref=@Model(type=HairColor::class))
     * @Groups({"onboarding"})
     * @SerializedName("onboarding_hair_color")
     */
    private $onboardingHairColor;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class)
     *
     * @SWG\Property(ref=@Model(type=Store::class))
     * @Groups({"onboarding"})
     * @SerializedName("onboarding_store")
     */
    private $onboardingStore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="shipment_address"
     * )
     * @Groups({"profile"})
     * @SerializedName("shipment_address")
     */
    private $shipmentAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="shipment_address_2"
     * )
     * @Groups({"profile"})
     * @SerializedName("shipment_address_2")
     */
    private $shipmentAddress2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="shipment_city"
     * )
     * @Groups({"profile"})
     * @SerializedName("shipment_city")
     */
    private $shipmentCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="shipment_zip"
     * )
     * @Groups({"profile"})
     * @SerializedName("shipment_zip")
     */
    private $shipmentZip;

    /**
     * @ORM\Column(type="boolean", nullable=true, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="is_shipment_same_as_billing"
     * )
     * @Groups({"profile"})
     * @SerializedName("is_shipment_same_as_billing")
     */
    private $isShipmentSameAsBilling;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SWG\Property(
     *     type="boolean",
     *     property="use_as_default_address"
     * )
     * @Groups({"profile"})
     * @SerializedName("use_as_default_address")
     */
    private $useAsDefaultAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="shipment_first_name"
     * )
     * @Groups({"profile"})
     * @SerializedName("shipment_first_name")
     */
    private $shipmentFirstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="shipment_last_name"
     * )
     * @Groups({"profile"})
     * @SerializedName("shipment_last_name")
     */
    private $shipmentLastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="billing_address"
     * )
     * @Groups({"profile"})
     * @SerializedName("billing_address")
     */
    private $billingAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="billing_address_2"
     * )
     * @Groups({"profile"})
     * @SerializedName("billing_address_2")
     */
    private $billingAddress2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="billing_city"
     * )
     * @Groups({"profile"})
     * @SerializedName("billing_city")
     */
    private $billingCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     property="billing_zip"
     * )
     * @Groups({"profile"})
     * @SerializedName("billing_zip")
     */
    private $billingZip;

    /**
     * @ORM\OneToMany(targetEntity=Box::class, mappedBy="customer")
     */
    private $boxes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $resetPasswordToken;

    public function __construct()
    {
        $this->isEnabled = true;
        $this->favouriteProducts = new ArrayCollection();
        $this->allowNotifications = true;
        $this->allowOrderNotifications = true;
        $this->allowsPromotionNotifications = true;
        $this->allowActivityNotifications = true;
        $this->allowEmailNotifications = true;
        $this->onboardingCategories = new ArrayCollection();
        $this->onboardingBrands = new ArrayCollection();
        $this->boxes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getSubscriptionEnd(): ?\DateTimeInterface
    {
        return $this->subscriptionEnd;
    }

    public function setSubscriptionEnd(?\DateTimeInterface $subscriptionEnd): self
    {
        $this->subscriptionEnd = $subscriptionEnd;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getFavouriteProducts(): Collection
    {
        return $this->favouriteProducts;
    }

    public function addFavouriteProduct(Product $favouriteProduct): self
    {
        if (!$this->favouriteProducts->contains($favouriteProduct)) {
            $this->favouriteProducts[] = $favouriteProduct;
        }

        return $this;
    }

    public function removeFavouriteProduct(Product $favouriteProduct): self
    {
        if ($this->favouriteProducts->contains($favouriteProduct)) {
            $this->favouriteProducts->removeElement($favouriteProduct);
        }

        return $this;
    }

    public function getAllowNotifications(): ?bool
    {
        return $this->allowNotifications;
    }

    public function setAllowNotifications(?bool $allowNotifications): self
    {
        $this->allowNotifications = $allowNotifications;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowOrderNotifications(): ?bool
    {
        return $this->allowOrderNotifications;
    }

    /**
     * @param bool $allowOrderNotifications
     */
    public function setAllowOrderNotifications(?bool $allowOrderNotifications): self
    {
        $this->allowOrderNotifications = $allowOrderNotifications;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowsPromotionNotifications(): ?bool
    {
        return $this->allowsPromotionNotifications;
    }

    /**
     * @param bool $allowsPromotionNotifications
     */
    public function setAllowsPromotionNotifications(?bool $allowsPromotionNotifications): self
    {
        $this->allowsPromotionNotifications = $allowsPromotionNotifications;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowActivityNotifications(): ?bool
    {
        return $this->allowActivityNotifications;
    }

    /**
     * @param bool $allowActivityNotifications
     */
    public function setAllowActivityNotifications(?bool $allowActivityNotifications): self
    {
        $this->allowActivityNotifications = $allowActivityNotifications;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getOnboardingCategories(): Collection
    {
        return $this->onboardingCategories;
    }

    public function addOnboardingCategory(Category $onboardingCategory): self
    {
        if (!$this->onboardingCategories->contains($onboardingCategory)) {
            $this->onboardingCategories[] = $onboardingCategory;
        }

        return $this;
    }

    public function removeOnboardingCategory(Category $onboardingCategory): self
    {
        if ($this->onboardingCategories->contains($onboardingCategory)) {
            $this->onboardingCategories->removeElement($onboardingCategory);
        }

        return $this;
    }

    public function getOnboardingSkinTone(): ?SkinTone
    {
        return $this->onboardingSkinTone;
    }

    public function setOnboardingSkinTone(?SkinTone $onboardingSkinTone): self
    {
        $this->onboardingSkinTone = $onboardingSkinTone;

        return $this;
    }

    /**
     * @return Collection|Brand[]
     */
    public function getOnboardingBrands(): Collection
    {
        return $this->onboardingBrands;
    }

    public function addOnboardingBrand(Brand $onboardingBrand): self
    {
        if (!$this->onboardingBrands->contains($onboardingBrand)) {
            $this->onboardingBrands[] = $onboardingBrand;
        }

        return $this;
    }

    public function removeOnboardingBrand(Brand $onboardingBrand): self
    {
        if ($this->onboardingBrands->contains($onboardingBrand)) {
            $this->onboardingBrands->removeElement($onboardingBrand);
        }

        return $this;
    }

    public function getOnboardingQuestionAnswer(): ?string
    {
        return $this->onboardingQuestionAnswer;
    }

    public function setOnboardingQuestionAnswer(?string $onboardingQuestionAnswer): self
    {
        $this->onboardingQuestionAnswer = $onboardingQuestionAnswer;

        return $this;
    }

    public function getOnboardingHairColor(): ?HairColor
    {
        return $this->onboardingHairColor;
    }

    public function setOnboardingHairColor(?HairColor $onboardingHairColor): self
    {
        $this->onboardingHairColor = $onboardingHairColor;

        return $this;
    }

    public function getOnboardingStore(): ?Store
    {
        return $this->onboardingStore;
    }

    public function setOnboardingStore(?Store $onboardingStore): self
    {
        $this->onboardingStore = $onboardingStore;

        return $this;
    }

    public function getShipmentAddress(): ?string
    {
        return $this->shipmentAddress;
    }

    public function setShipmentAddress(?string $shipmentAddress): self
    {
        $this->shipmentAddress = $shipmentAddress;

        return $this;
    }

    public function getShipmentAddress2(): ?string
    {
        return $this->shipmentAddress2;
    }

    public function setShipmentAddress2(?string $shipmentAddress2): self
    {
        $this->shipmentAddress2 = $shipmentAddress2;

        return $this;
    }

    public function getShipmentCity(): ?string
    {
        return $this->shipmentCity;
    }

    public function setShipmentCity(?string $shipmentCity): self
    {
        $this->shipmentCity = $shipmentCity;

        return $this;
    }

    public function getShipmentZip(): ?string
    {
        return $this->shipmentZip;
    }

    public function setShipmentZip(?string $shipmentZip): self
    {
        $this->shipmentZip = $shipmentZip;

        return $this;
    }

    public function getIsShipmentSameAsBilling(): ?bool
    {
        return $this->isShipmentSameAsBilling;
    }

    public function setIsShipmentSameAsBilling(?bool $isShipmentSameAsBilling): self
    {
        $this->isShipmentSameAsBilling = $isShipmentSameAsBilling;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingAddress2(): ?string
    {
        return $this->billingAddress2;
    }

    public function setBillingAddress2(?string $billingAddress2): self
    {
        $this->billingAddress2 = $billingAddress2;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(?string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingZip(): ?string
    {
        return $this->billingZip;
    }

    public function setBillingZip(?string $billingZip): self
    {
        $this->billingZip = $billingZip;

        return $this;
    }

    /**
     * @return Collection|Box[]
     */
    public function getBoxes(): Collection
    {
        return $this->boxes;
    }

    public function addBox(Box $box): self
    {
        if (!$this->boxes->contains($box)) {
            $this->boxes[] = $box;
            $box->setCustomer($this);
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        if ($this->boxes->contains($box)) {
            $this->boxes->removeElement($box);
            // set the owning side to null (unless already changed)
            if ($box->getCustomer() === $this) {
                $box->setCustomer(null);
            }
        }

        return $this;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken): self
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

    public function getAllowEmailNotifications(): ?bool
    {
        return $this->allowEmailNotifications;
    }

    public function setAllowEmailNotifications(?bool $allowEmailNotifications): self
    {
        $this->allowEmailNotifications = $allowEmailNotifications;

        return $this;
    }

    public function getUseAsDefaultAddress(): ?bool
    {
        return $this->useAsDefaultAddress;
    }

    public function setUseAsDefaultAddress(?bool $useAsDefaultAddress): self
    {
        $this->useAsDefaultAddress = $useAsDefaultAddress;

        return $this;
    }

    public function getShipmentFirstName(): ?string
    {
        return $this->shipmentFirstName;
    }

    public function setShipmentFirstName(?string $shipmentFirstName): self
    {
        $this->shipmentFirstName = $shipmentFirstName;

        return $this;
    }

    public function getShipmentLastName(): ?string
    {
        return $this->shipmentLastName;
    }

    public function setShipmentLastName(?string $shipmentLastName): self
    {
        $this->shipmentLastName = $shipmentLastName;

        return $this;
    }

}
