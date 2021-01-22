<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 *
 * @SWG\Definition(
 *     @SWG\Property(
 *        property="color",
 *        type="string",
 *        description="Color of variant."
 *     ),
 *     @SWG\Property(
 *        property="size_type",
 *        type="string",
 *        description="Size type of variant."
 *     )
 * )
 */
class ProductVariant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @SWG\Property(
     *     type="number",
     *     description="ID of variant",
     *     property="id"
     * )
     * @Groups({"general", "order"})
     * @SerializedName("id")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productVariants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @SWG\Property(ref=@Model(type=Product::class))
     * @Groups({"order"})
     * @SerializedName("product")
     */
    private $product;

    /**
     * @Assert\NotBlank(
     *     message = "The email can not be blank.",
     *     groups={"updateProfile", "register"}
     * )
     *
     * @ORM\Column(type="string", length=255)
     *
     * @SWG\Property(
     *     type="string",
     *     description="SKU of variant",
     *     property="sku"
     * )
     * @Groups({"general", "order"})
     * @SerializedName("sku")
     */
    private $sku;

    /**
     * @ORM\Column(type="float")
     *
     * @SWG\Property(
     *     type="number",
     *     description="Price of the product",
     *     property="price"
     * )
     * @Groups({"general"})
     * @SerializedName("price")
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @SWG\Property(
     *     type="number",
     *     description="Old price of the product",
     *     property="old_price"
     * )
     * @Groups({"general"})
     * @SerializedName("old_price")
     */
    private $oldPrice;

    /**
     * @ORM\OneToMany(targetEntity=OrderEntry::class, mappedBy="productVariant")
     */
    private $orderEntries;

    /**
     * @ORM\Column(type="integer")
     *
     * @SWG\Property(
     *     type="integer",
     *     description="Actual amount of product",
     *     property="stock_amount"
     * )
     * @Groups({"general"})
     * @SerializedName("stock_amount")
     */
    private $stockAmount;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @SWG\Property(
     *     type="float",
     *     description="Size of product variant",
     *     property="size"
     * )
     * @Groups({"general"})
     * @SerializedName("size")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity=SizeType::class)
     */
    private $sizeType;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class)
     */
    private $color;

    public function __construct()
    {
        $this->orderEntries = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getSku();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

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

    public function getOldPrice(): ?float
    {
        return $this->oldPrice;
    }

    public function setOldPrice(float $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    /**
     * @return Collection|OrderEntry[]
     */
    public function getOrderEntries(): Collection
    {
        return $this->orderEntries;
    }

    public function addOrderEntry(OrderEntry $orderEntry): self
    {
        if (!$this->orderEntries->contains($orderEntry)) {
            $this->orderEntries[] = $orderEntry;
            $orderEntry->setProductVariant($this);
        }

        return $this;
    }

    public function removeOrderEntry(OrderEntry $orderEntry): self
    {
        if ($this->orderEntries->contains($orderEntry)) {
            $this->orderEntries->removeElement($orderEntry);
            // set the owning side to null (unless already changed)
            if ($orderEntry->getProductVariant() === $this) {
                $orderEntry->setProductVariant(null);
            }
        }

        return $this;
    }

    public function getStockAmount(): ?int
    {
        return $this->stockAmount;
    }

    public function setStockAmount(int $stockAmount): self
    {
        $this->stockAmount = $stockAmount;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(?float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSizeType(): ?SizeType
    {
        return $this->sizeType;
    }

    public function setSizeType(?SizeType $sizeType): self
    {
        $this->sizeType = $sizeType;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }
}
