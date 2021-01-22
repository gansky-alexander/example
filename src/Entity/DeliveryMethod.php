<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 *
 * @SWG\Definition(
 *     @SWG\Property(
 *        property="name",
 *        type="string",
 *        description="Translated name of delivery method."
 *     )
 * )
 */
class DeliveryMethod implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @SerializedName("id")
     * @Groups({"general", "order"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     *
     * @SerializedName("price")
     * @Groups({"general", "order"})
     */
    private $price;

    public function __toString()
    {
        return $this->getDefaultName();
    }

    public function getDefaultName(): string
    {
       return $this->translate('en')->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
