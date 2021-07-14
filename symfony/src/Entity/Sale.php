<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaleRepository::class)
 */
class Sale
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="sales")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="sales")
     */
    private $buyer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cancelled;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="sales")
     */
    private $responsibleCancellation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBuyer(): ?user
    {
        return $this->buyer;
    }

    public function setBuyer(?user $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getCancelled(): ?bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancelled): self
    {
        $this->cancelled = $cancelled;

        return $this;
    }

    public function getResponsibleCancellation(): ?user
    {
        return $this->responsibleCancellation;
    }

    public function setResponsibleCancellation(?user $responsibleCancellation): self
    {
        $this->responsibleCancellation = $responsibleCancellation;

        return $this;
    }
}
