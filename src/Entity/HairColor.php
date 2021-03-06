<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 *
 * @SWG\Definition(
 *     @SWG\Property(
 *        property="name",
 *        type="string",
 *        description="Translated name of hair color."
 *     )
 * )
 */
class HairColor implements TranslatableInterface
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
     * @Groups({"general", "onboarding"})
     * @SerializedName("id")
     */
    private $id;

    /**
     * @SWG\Property(
     *     type="string",
     *     description="Hair color.",
     *     property="color"
     * )
     * @Groups({"general", "onboarding"})
     * @SerializedName("color")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    public function getNameDefault(): string
    {
        return $this->translate('en')->getName();
    }

    public function __toString()
    {
        return $this->getNameDefault();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        if($color != '#000000') {
            $this->color = $color;
        }

        return $this;
    }
}
