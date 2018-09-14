<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Charity", mappedBy="category")
     */
    private $charities;

    public function __construct()
    {
        $this->charities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Charity[]
     */
    public function getCharities(): Collection
    {
        return $this->charities;
    }

    public function addCharity(Charity $charity): self
    {
        if (!$this->charities->contains($charity)) {
            $this->charities[] = $charity;
            $charity->setCategory($this);
        }

        return $this;
    }

    public function removeCharity(Charity $charity): self
    {
        if ($this->charities->contains($charity)) {
            $this->charities->removeElement($charity);
            // set the owning side to null (unless already changed)
            if ($charity->getCategory() === $this) {
                $charity->setCategory(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->name;
    }
}
