<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity()
 *
 * @SWG\Definition(
 *     @SWG\Property(
 *        property="name",
 *        type="string",
 *        description="Translated name of category."
 *     )
 * )
 */
class Category implements TranslatableInterface
{
    use TranslatableTrait;

    const PATH_TO_IMAGE_FOLDER = 'images/category/';

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
     * @Groups({"general"})
     * @SerializedName("id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     description="Category image.",
     *     property="image"
     * )
     * @Groups({"general"})
     * @SerializedName("image")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     description="Color of category.",
     *     property="color"
     * )
     * @Groups({"general"})
     * @SerializedName("color")
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="parent")
     *
     * @MaxDepth(2)
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         ref=@Model(type=Category::class)
     *     ),
     *     property="children"
     * )
     * @Groups({"general"})
     * @SerializedName("children")
     */
    private $children;

    /**
     * @var UploadedFile
     */
    private $imageFile;

    public function getNameDefault(): string
    {
        return $this->translate('en')->getName();
    }

    public function __toString()
    {
        $parentName = $this->getParent() ? (string)$this->getParent() : '';

        return $parentName ? $parentName . ' -> ' . $this->getNameDefault() : $this->getNameDefault();
    }

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function uploadImage($uniqid)
    {
        if ($file = $this->getImageFile()) {
            $fileExt = $this->imageFile->getClientOriginalExtension();
            $fileName = md5($uniqid . time());
            $imagePath = self::PATH_TO_IMAGE_FOLDER . $fileName . '.' . $fileExt;

            $file->move(self::PATH_TO_IMAGE_FOLDER, $fileName . '.' . $fileExt);
            $this->setImage('/' . $imagePath);
        }
    }
}
