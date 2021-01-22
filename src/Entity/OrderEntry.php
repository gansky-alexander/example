<?php

namespace App\Entity;

use App\Entity\ProductVariant;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 */
class OrderEntry
{
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
     * @Groups({"order"})
     * @SerializedName("id")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="entries")
     */
    private $order;

    /**
     * @ORM\Column(type="integer")
     *
     * @SWG\Property(
     *     type="integer",
     *     description="Quantity of products",
     *     property="quantity"
     * )
     * @Groups({"order"})
     * @SerializedName("quantity")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     *
     * @SWG\Property(
     *     type="number",
     *     description="Price of products",
     *     property="price"
     * )
     * @Groups({"order"})
     * @SerializedName("price")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class, inversedBy="orderEntries")
     * @ORM\JoinColumn(nullable=false)
     *
     * @SWG\Property(ref=@Model(type=ProductVariant::class))
     * @Groups({"order"})
     * @SerializedName("product_variant")
     */
    private $productVariant;

    public function getAmount()
    {
        return $this->getQuantity() * $this->getPrice();
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getProductVariant(): ?ProductVariant
    {
        return $this->productVariant;
    }

    public function setProductVariant(?ProductVariant $productVariant): self
    {
        $this->productVariant = $productVariant;

        return $this;
    }
}
