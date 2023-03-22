<?php

namespace App\Entity;


use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:collection']],
    // itemOperations:[
    //     'get' => [
    //         'normalization_context' => ['groups' => ['read:item','read:Article']]
    //     ],
    // ]
)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:collection'])]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?\DateTimeImmutable $creates_at = null;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'article')]
    #[Groups(['read:item'])]
    private Collection $categories;

    #[ORM\Column(length: 255,nullable:true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255,nullable:true)]
    #[Groups(['read:collection'])]
    private ?string $fromNow = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->creates_at = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function prePersist(){
        $this->slug = (new Slugify())->slugify($this->name);
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatesAt(): ?\DateTimeImmutable
    {
        return $this->creates_at;
    }

    public function setCreatesAt(\DateTimeImmutable $creates_at): self
    {
        $this->creates_at = $creates_at;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addArticle($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeArticle($this);
        }

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

    public function getFromNow(): ?string
    {
        return Carbon::instance($this->creates_at)->diffForHumans();
    }
    

    public function setFromNow(string $fromNow): self
    {
        $this->fromNow = $fromNow;

        return $this;
    }
}
