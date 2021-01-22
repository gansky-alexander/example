<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 */
class ProductImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productImages",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=SonataMediaMedia::class)
     * @ORM\JoinColumn(nullable=true)
     *
     * @Groups({"general", "order"})
     * @SerializedName("image")
     */
    private $mediaImage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @Groups({"general", "order"})
     * @SerializedName("is_main")
     */
    private $isMain;

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

    public function getMediaImage(): ?SonataMediaMedia
    {
        return $this->mediaImage;
    }

    public function setMediaImage(?SonataMediaMedia $mediaImage): self
    {
        $this->mediaImage = $mediaImage;

        return $this;
    }

    public function getIsMain(): ?bool
    {
        return $this->isMain;
    }

    public function setIsMain(?bool $isMain): self
    {
        $this->isMain = $isMain;

        return $this;
    }
}
