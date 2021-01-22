<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

/**
 * @ORM\Entity()
 */
class ProductTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ingredients;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ingredientsContentFormatter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ingredientsRaw;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionContentFormatter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionRaw;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(?string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getIngredientsContentFormatter(): ?string
    {
        return $this->ingredientsContentFormatter;
    }

    public function setIngredientsContentFormatter(?string $ingredientsContentFormatter): self
    {
        $this->ingredientsContentFormatter = $ingredientsContentFormatter;

        return $this;
    }

    public function getIngredientsRaw(): ?string
    {
        return $this->ingredientsRaw;
    }

    public function setIngredientsRaw(?string $ingredientsRaw): self
    {
        $this->ingredientsRaw = $ingredientsRaw;

        return $this;
    }

    public function getDescriptionContentFormatter(): ?string
    {
        return $this->descriptionContentFormatter;
    }

    public function setDescriptionContentFormatter(?string $descriptionContentFormatter): self
    {
        $this->descriptionContentFormatter = $descriptionContentFormatter;

        return $this;
    }

    public function getDescriptionRaw(): ?string
    {
        return $this->descriptionRaw;
    }

    public function setDescriptionRaw(?string $descriptionRaw): self
    {
        $this->descriptionRaw = $descriptionRaw;

        return $this;
    }
}
