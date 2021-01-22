<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 */
class Store
{
    const PATH_TO_IMAGE_FOLDER = 'images/store/';

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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SWG\Property(
     *     type="string",
     *     description="Logo of store.",
     *     property="image"
     * )
     * @Groups({"general", "onboarding"})
     * @SerializedName("image")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @SWG\Property(
     *     type="string",
     *     description="Name of store.",
     *     property="name"
     * )
     * @Groups({"general", "onboarding"})
     * @SerializedName("name")
     */
    private $name;

    /**
     * @var UploadedFile
     */
    private $imageFile;

    public function __toString()
    {
        return $this->getName();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
