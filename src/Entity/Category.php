<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $roman = null;

    #[ORM\Column]
    private ?bool $comic = null;

    #[ORM\Column]
    private ?bool $thriller = null;

    #[ORM\Column]
    private ?bool $history = null;

    #[ORM\Column]
    private ?bool $drama = null;

    #[ORM\Column]
    private ?bool $cook = null;

    #[ORM\Column]
    private ?bool $romance = null;

    #[ORM\Column]
    private ?bool $child = null;

    #[ORM\Column]
    private ?bool $religion = null;

    #[ORM\Column]
    private ?bool $sport = null;

    #[ORM\Column]
    private ?bool $scholar = null;

    #[ORM\Column]
    private ?bool $sf = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'category')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isRoman(): ?bool
    {
        return $this->roman;
    }

    public function setRoman(bool $roman): static
    {
        $this->roman = $roman;

        return $this;
    }

    public function isComic(): ?bool
    {
        return $this->comic;
    }

    public function setComic(bool $comic): static
    {
        $this->comic = $comic;

        return $this;
    }

    public function isThriller(): ?bool
    {
        return $this->thriller;
    }

    public function setThriller(bool $thriller): static
    {
        $this->thriller = $thriller;

        return $this;
    }

    public function isHistory(): ?bool
    {
        return $this->history;
    }

    public function setHistory(bool $history): static
    {
        $this->history = $history;

        return $this;
    }

    public function isDrama(): ?bool
    {
        return $this->drama;
    }

    public function setDrama(bool $drama): static
    {
        $this->drama = $drama;

        return $this;
    }

    public function isCook(): ?bool
    {
        return $this->cook;
    }

    public function setCook(bool $cook): static
    {
        $this->cook = $cook;

        return $this;
    }

    public function isRomance(): ?bool
    {
        return $this->romance;
    }

    public function setRomance(bool $romance): static
    {
        $this->romance = $romance;

        return $this;
    }

    public function isChild(): ?bool
    {
        return $this->child;
    }

    public function setChild(bool $child): static
    {
        $this->child = $child;

        return $this;
    }

    public function isReligion(): ?bool
    {
        return $this->religion;
    }

    public function setReligion(bool $religion): static
    {
        $this->religion = $religion;

        return $this;
    }

    public function isSport(): ?bool
    {
        return $this->sport;
    }

    public function setSport(bool $sport): static
    {
        $this->sport = $sport;

        return $this;
    }

    public function isScholar(): ?bool
    {
        return $this->scholar;
    }

    public function setScholar(bool $scholar): static
    {
        $this->scholar = $scholar;

        return $this;
    }

    public function isSf(): ?bool
    {
        return $this->sf;
    }

    public function setSf(bool $sf): static
    {
        $this->sf = $sf;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addCategory($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            $book->removeCategory($this);
        }

        return $this;
    }
}
