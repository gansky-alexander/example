<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 */
class ReviewFile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @SWG\Property(
     *     type="string",
     *     description="ID",
     *     property="path"
     * )
     * @Groups({"general"})
     * @SerializedName("path")
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=Review::class, inversedBy="reviewFiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $review;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getReview(): ?Review
    {
        return $this->review;
    }

    public function setReview(?Review $review): self
    {
        $this->review = $review;

        return $this;
    }
}
