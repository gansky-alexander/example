<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 */
class Blog
{
    const PATH_TO_IMAGE_FOLDER = 'images/blog/';

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
     * @ORM\Column(type="string", length=255)
     *
     * @SerializedName("title")
     * @Groups({"general"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *
     * @SerializedName("text")
     * @Groups({"general"})
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SerializedName("image")
     * @Groups({"general"})
     */
    private $image;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SerializedName("is_for_you")
     * @Groups({"general"})
     */
    private $isForYou;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SerializedName("is_popular")
     * @Groups({"general"})
     */
    private $isPopular;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @SerializedName("is_published")
     * @Groups({"general"})
     */
    private $isPublished;

    /**
     * @ORM\Column(type="date")
     *
     * @SerializedName("publish_date")
     * @Groups({"general"})
     */
    private $publishDate;

    /**
     * @ORM\ManyToMany(targetEntity=BlogTag::class)
     *
     * @SerializedName("tags")
     * @Groups({"general"})
     */
    private $tags;

    /**
     * @var UploadedFile
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contentFormatter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rawContent;

    public function __toString()
    {
        return $this->getTitle();
    }

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
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

    public function getIsForYou(): ?bool
    {
        return $this->isForYou;
    }

    public function setIsForYou(?bool $isForYou): self
    {
        $this->isForYou = $isForYou;

        return $this;
    }

    public function getIsPopular(): ?bool
    {
        return $this->isPopular;
    }

    public function setIsPopular(?bool $isPopular): self
    {
        $this->isPopular = $isPopular;

        return $this;
    }

    /**
     * @return Collection|BlogTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(BlogTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(BlogTag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

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

    public function getContentFormatter(): ?string
    {
        return $this->contentFormatter;
    }

    public function setContentFormatter(?string $contentFormatter): self
    {
        $this->contentFormatter = $contentFormatter;

        return $this;
    }

    public function getRawContent(): ?string
    {
        return $this->rawContent;
    }

    public function setRawContent(?string $rawContent): self
    {
        $this->rawContent = $rawContent;

        return $this;
    }
}
