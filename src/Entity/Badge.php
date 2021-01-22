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
class Badge implements TranslatableInterface
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SerializedName("color")
     * @Groups({"general"})
     */
    private $color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @SerializedName("sort_order")
     * @Groups({"general"})
     */
    private $sortOrder;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SerializedName("used_for_sort")
     * @Groups({"general"})
     */
    private $usedForSort;

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

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(?int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function getUsedForSort(): ?bool
    {
        return $this->usedForSort;
    }

    public function setUsedForSort(?bool $usedForSort): self
    {
        $this->usedForSort = $usedForSort;

        return $this;
    }
}
