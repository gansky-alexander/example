<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Validator as FyneAssert;

/**
 * @ORM\Entity()
 *
 * @FyneAssert\IsFinishedBox
 */
class Box
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @SWG\Property(
     *     type="integer",
     *     description="ID",
     *     property="id"
     * )
     * @Groups({"general"})
     * @SerializedName("id")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     *
     * @SWG\Property(
     *     type="string",
     *     description="Date.",
     *     property="date"
     * )
     * @Groups({"general"})
     * @SerializedName("date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="boxes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFinished;

    /**
     * @ORM\OneToMany(targetEntity=BoxItem::class, mappedBy="box", orphanRemoval=true, cascade={"persist"})
     *
     * @Assert\Count(
     *      min = 1,
     *      max = 5,
     *      minMessage = "You must specify at least one box",
     *      maxMessage = "You cannot specify more than {{ limit }} boxes"
     * )
     *
     * @SWG\Property(
     *     description="Items.",
     *     property="items"
     * )
     * @Groups({"general"})
     * @SerializedName("items")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getDate()->format('Y M') . ' - ' . $this->getCustomer()->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * @return Collection|BoxItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(BoxItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setBox($this);
        }

        return $this;
    }

    public function removeItem(BoxItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getBox() === $this) {
                $item->setBox(null);
            }
        }

        return $this;
    }
}
