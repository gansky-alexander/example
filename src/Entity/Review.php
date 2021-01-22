<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 *
 * @SWG\Definition(
 *     @SWG\Property(
 *        property="was_liked",
 *        type="boolean",
 *        description="Was this Review liked by current user."
 *     )
 * )
 */
class Review
{
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
     * @ORM\ManyToOne(targetEntity=Customer::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @SWG\Property(ref=@Model(type=Customer::class))
     * @Groups({"general"})
     * @SerializedName("customer")
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     *
     * @SWG\Property(ref=@Model(type=Product::class))
     * @Groups({"general"})
     * @SerializedName("product")
     */
    private $product;

    /**
     * @ORM\Column(type="text")
     *
     * @SWG\Property(
     *     type="string",
     *     description="Text of the review",
     *     property="text"
     * )
     * @Groups({"general"})
     * @SerializedName("text")
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity=ReviewFile::class, mappedBy="review", cascade={"ALL"})
     *
     * @SWG\Property(
     *     type="object",
     *     description="File of review",
     *     property="files"
     * )
     * @Groups({"general"})
     * @SerializedName("files")
     */
    private $reviewFiles;

    /**
     * @ORM\Column(type="float")
     *
     * @SWG\Property(
     *     type="float",
     *     description="Rate",
     *     property="rate"
     * )
     * @Groups({"general"})
     * @SerializedName("rate")
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     *
     * @SWG\Property(
     *     type="string",
     *     description="Creation date",
     *     property="created_at"
     * )
     * @Groups({"general"})
     * @SerializedName("created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=ReviewLike::class, mappedBy="review", cascade={"all"})
     */
    private $likes;

    public function __construct()
    {
        $this->reviewFiles = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getCustomer()->getEmail() . ' -> ' . $this->getProduct()->getNameDefault();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|ReviewFile[]
     */
    public function getReviewFiles(): Collection
    {
        return $this->reviewFiles;
    }

    public function addReviewFile(ReviewFile $reviewFile): self
    {
        if (!$this->reviewFiles->contains($reviewFile)) {
            $this->reviewFiles[] = $reviewFile;
            $reviewFile->setReview($this);
        }

        return $this;
    }

    public function removeReviewFile(ReviewFile $reviewFile): self
    {
        if ($this->reviewFiles->contains($reviewFile)) {
            $this->reviewFiles->removeElement($reviewFile);
            // set the owning side to null (unless already changed)
            if ($reviewFile->getReview() === $this) {
                $reviewFile->setReview(null);
            }
        }

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|ReviewLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(ReviewLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setReview($this);
        }

        return $this;
    }

    public function removeLike(ReviewLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getReview() === $this) {
                $like->setReview(null);
            }
        }

        return $this;
    }
}
