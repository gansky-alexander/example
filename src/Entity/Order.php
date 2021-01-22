<?php

namespace App\Entity;

use App\Entity\OrderEntry;
use App\Entity\DeliveryMethod;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity()
 * @ORM\Table(name="`order`")
 */
class Order
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETE = 'complete';
    const STATUS_CANCELED = 'canceled';

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
     * @Groups({"order"})
     * @SerializedName("id")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @SWG\Property(
     *     type="string",
     *     description="Date of creation of order",
     *     property="created_at"
     * )
     * @Groups({"order"})
     * @SerializedName("created_at")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @SWG\Property(
     *     type="string",
     *     description="ID",
     *     property="status"
     * )
     * @Groups({"order"})
     * @SerializedName("status")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=OrderEntry::class, mappedBy="order", cascade={"persist"})
     *
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="object",
     *         ref=@Model(type=OrderEntry::class)
     *     ),
     *     description="Entries of the Order",
     *     property="entries"
     * )
     * @Groups({"order"})
     * @SerializedName("entries")
     */
    private $entries;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveryMethod::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @SWG\Property(ref=@Model(type=DeliveryMethod::class))
     * @Groups({"order"})
     * @SerializedName("delivery_method")
     */
    private $deliveryMethod;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shipmentAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shipmentAddress2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shipmentCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shipmentZip;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isShipmentSameAsBilling;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $billingAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $billingAddress2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $billingCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $billingZip;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->entries = new ArrayCollection();
    }

    public function __toString()
    {
        return '#' . $this->getId();
    }

    public function getAmount()
    {
        $total = 0;
        /** @var OrderEntry $entry */
        foreach ($this->entries as $entry) {
            $total += $entry->getAmount();
        }

        return $total;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|OrderEntry[]
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(OrderEntry $entry): self
    {
        if (!$this->entries->contains($entry)) {
            $this->entries[] = $entry;
            $entry->setOrder($this);
        }

        return $this;
    }

    public function removeProduct(OrderEntry $entry): self
    {
        if ($this->entries->contains($entry)) {
            $this->entries->removeElement($entry);
            // set the owning side to null (unless already changed)
            if ($entry->getOrder() === $this) {
                $entry->setOrder(null);
            }
        }

        return $this;
    }

    public function getDeliveryMethod(): ?DeliveryMethod
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(?DeliveryMethod $deliveryMethod): self
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    public function getShipmentAddress(): ?string
    {
        return $this->shipmentAddress;
    }

    public function setShipmentAddress(string $shipmentAddress): self
    {
        $this->shipmentAddress = $shipmentAddress;

        return $this;
    }

    public function getShipmentAddress2(): ?string
    {
        return $this->shipmentAddress2;
    }

    public function setShipmentAddress2(string $shipmentAddress2): self
    {
        $this->shipmentAddress2 = $shipmentAddress2;

        return $this;
    }

    public function getShipmentCity(): ?string
    {
        return $this->shipmentCity;
    }

    public function setShipmentCity(string $shipmentCity): self
    {
        $this->shipmentCity = $shipmentCity;

        return $this;
    }

    public function getShipmentZip(): ?string
    {
        return $this->shipmentZip;
    }

    public function setShipmentZip(string $shipmentZip): self
    {
        $this->shipmentZip = $shipmentZip;

        return $this;
    }

    public function getIsShipmentSameAsBilling(): ?bool
    {
        return $this->isShipmentSameAsBilling;
    }

    public function setIsShipmentSameAsBilling(?bool $isShipmentSameAsBilling): self
    {
        $this->isShipmentSameAsBilling = $isShipmentSameAsBilling;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingAddress2(): ?string
    {
        return $this->billingAddress2;
    }

    public function setBillingAddress2(string $billingAddress2): self
    {
        $this->billingAddress2 = $billingAddress2;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(?string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingZip(): ?string
    {
        return $this->billingZip;
    }

    public function setBillingZip(?string $billingZip): self
    {
        $this->billingZip = $billingZip;

        return $this;
    }
}
