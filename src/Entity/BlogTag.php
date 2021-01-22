<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 */
class BlogTag implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @SerializedName("id")
     * @Groups({"general"})
     */
    private $id;

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
}
