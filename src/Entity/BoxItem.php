<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 */
class BoxItem
{
    const CREATED_BY_ME = 'me';
    const CREATED_BY_SYSTEM = 'system';

    const CREATED_BY = [
        self::CREATED_BY_ME,
        self::CREATED_BY_SYSTEM,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Box::class, inversedBy="items", cascade={"persist"})
     */
    private $box;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @SWG\Property(ref=@Model(type=ProductVariant::class))
     * @Groups({"general"})
     * @SerializedName("product_variant")
     */
    private $variant;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @SWG\Property(
     *     type="string",
     *     description="Created by.",
     *     property="created_by"
     * )
     * @Groups({"general"})
     * @SerializedName("created_by")
     */
    private $createdBy;

    public function __toString()
    {
        return  $this->getVariant()->getSku();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): self
    {
        $this->box = $box;

        return $this;
    }

    public function getVariant(): ?ProductVariant
    {
        return $this->variant;
    }

    public function setVariant(?ProductVariant $variant): self
    {
        $this->variant = $variant;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        if (!in_array($createdBy, self::CREATED_BY)) {
            throw new InvalidArgumentException();
        }
        $this->createdBy = $createdBy;

        return $this;
    }

}
