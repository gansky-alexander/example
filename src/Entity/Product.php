<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 *
 * @SWG\Definition(
 *     @SWG\Property(
 *        property="name",
 *        type="string",
 *        description="Translated name product."
 *     ),
 *     @SWG\Property(
 *        property="short_description",
 *        type="string",
 *        description="Translated short description of product."
 *     ),
 *     @SWG\Property(
 *        property="description",
 *        type="string",
 *        description="Translated description of product."
 *     )
 * )
 */
class Product implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @SWG\Property(
     *     type="string",
     *     description="ID",
     *     property="id"
     * )
     * @Groups({"general", "order"})
     * @SerializedName("id")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class)
     *
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         @SWG\Property(property="id", type="integer"),
     *         @SWG\Property(property="name", type="string"),
     *         @SWG\Property(property="image", type="string"),
     *         @SWG\Property(property="color", type="string"),
     *         @SWG\Property(property="parent", type="integer")
     *     ),
     *     description="Categories of the product",
     *     property="categories"
     * )
     * @Groups({"general"})
     * @SerializedName("categories")
     */
    private $categories;

    /**
     * @ORM\Column(type="float")
     *
     * @SWG\Property(
     *     type="number",
     *     description="Average rating of the product",
     *     property="rating"
     * )
     * @Groups({"general", "order"})
     * @SerializedName("rating")
     */
    private $rating;

    /**
     * @ORM\Column(type="integer")
     *
     * @SWG\Property(
     *     type="integer",
     *     description="Amount ot reviews",
     *     property="amount_of_reviews"
     * )
     * @Groups({"general", "order"})
     * @SerializedName("amount_of_reviews")
     */
    private $amountOfReviews;

    /**
     * @ORM\Column(type="boolean")
     *
     * @SWG\Property(
     *     type="boolean",
     *     description="Is product active",
     *     property="is_active"
     * )
     * @Groups({"general"})
     * @SerializedName("is_active")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     *
     * @SWG\Property(
     *     type="boolean",
     *     description="Is product using for manage boxes",
     *     property="used_for_box"
     * )
     * @Groups({"general"})
     * @SerializedName("used_for_box")
     */
    private $usedForBox;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     *
     * @SWG\Property(ref=@Model(type=Brand::class))
     * @Groups({"general", "order"})
     * @SerializedName("brand")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity=Badge::class)
     *
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         @SWG\Property(property="id", type="integer"),
     *         @SWG\Property(property="name", type="string"),
     *         @SWG\Property(property="color", type="string"),
     *     ),
     *     description="Badges of the product",
     *     property="badges"
     * )
     * @Groups({"general"})
     * @SerializedName("badges")
     */
    private $badges;

    /**
     * @ORM\ManyToOne(targetEntity=HairColor::class)
     *
     * @SWG\Property(ref=@Model(type=HairColor::class))
     * @Groups({"general"})
     * @SerializedName("hair_color")
     */
    private $hairColor;

    /**
     * @ORM\OneToMany(targetEntity=ProductImage::class, mappedBy="product", orphanRemoval=true, cascade={"all"})
     *
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         @SWG\Property(property="image", type="string"),
     *         @SWG\Property(property="is_main", type="boolean"),
     *     ),
     *     description="Images of the product",
     *     property="product_images"
     * )
     * @Groups({"general", "order"})
     * @SerializedName("product_images")
     */
    private $productImages;

    /**
     * @ORM\OneToMany(targetEntity=ProductVariant::class, mappedBy="product", orphanRemoval=true, cascade={"persist"})
     *
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         @SWG\Property(property="price", type="number"),
     *         @SWG\Property(property="old_price", type="number"),
     *         @SWG\Property(property="stock_amount", type="integer"),
     *         @SWG\Property(property="skin_tone", ref=@Model(type=SkinTone::class)),
     *     ),
     *     description="Variants of the product",
     *     property="variants"
     * )
     * @Groups({"general"})
     * @SerializedName("variants")
     */
    private $productVariants;

    /**
     * @ORM\Column(type="float")
     *
     * @SWG\Property(
     *     type="float",
     *     description="Product price for list",
     *     property="price"
     * )
     * @Groups({"general"})
     * @SerializedName("price")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="product")
     */
    private $reviews;

    public function getNameDefault(): string
    {
        return $this->translate('en')->getName();
    }

    public function __toString()
    {
        return $this->getNameDefault();
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->badges = new ArrayCollection();
        $this->productImages = new ArrayCollection();
        $this->productVariants = new ArrayCollection();
        $this->rating = 5;
        $this->amountOfReviews = 0;
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getAmountOfReviews(): ?float
    {
        return $this->amountOfReviews;
    }

    public function setAmountOfReviews(float $amountOfReviews): self
    {
        $this->amountOfReviews = $amountOfReviews;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getUsedForBox(): ?bool
    {
        return $this->usedForBox;
    }

    public function setUsedForBox(bool $usedForBox): self
    {
        $this->usedForBox = $usedForBox;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Badge[]
     */
    public function getBadges(): Collection
    {
        return $this->badges;
    }

    public function addBadge(Badge $badge): self
    {
        if (!$this->badges->contains($badge)) {
            $this->badges[] = $badge;
        }

        return $this;
    }

    public function removeBadge(Badge $badge): self
    {
        if ($this->badges->contains($badge)) {
            $this->badges->removeElement($badge);
        }

        return $this;
    }

    public function getHairColor(): ?HairColor
    {
        return $this->hairColor;
    }

    public function setHairColor(?HairColor $hairColor): self
    {
        $this->hairColor = $hairColor;

        return $this;
    }

    /**
     * @return Collection|ProductImage[]
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addProductImage(ProductImage $productImage): self
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages[] = $productImage;
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): self
    {
        if ($this->productImages->contains($productImage)) {
            $this->productImages->removeElement($productImage);
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductVariant[]
     */
    public function getProductVariants(): Collection
    {
        return $this->productVariants;
    }

    public function addProductVariant(ProductVariant $productVariant): self
    {
        if (!$this->productVariants->contains($productVariant)) {
            $this->productVariants[] = $productVariant;
            $productVariant->setProduct($this);
        }

        return $this;
    }

    public function removeProductVariant(ProductVariant $productVariant): self
    {
        if ($this->productVariants->contains($productVariant)) {
            $this->productVariants->removeElement($productVariant);
            // set the owning side to null (unless already changed)
            if ($productVariant->getProduct() === $this) {
                $productVariant->setProduct(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setProductVariant($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getProductVariant() === $this) {
                $review->setProductVariant(null);
            }
        }

        return $this;
    }

}
