<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\PageRepository::class)
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;
    /**
     * @ORM\Column(type="text")
     */
    private $contenu;
    /**
     * @ORM\Column(type="boolean")
     */
    private $header;
    /**
     * @ORM\Column(type="boolean")
     */
    private $footer;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="pages")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
    
    function getHeader(): bool
    {
        return $this->header;
    }

    function getFooter(): bool
    {
        return $this->footer;
    }

    function setHeader(?bool $header) {
        $this->header = $header;
    }

    function setFooter(?bool $footer) {
        $this->footer = $footer;
    }
        
    public function __toString(): string {
        return $this->nom;
    }
    
    public function getClass(): string
    {
        return Page::class;
    }

}
