<?php

class Book extends AbstractEntity
{
    private string $title;
    private string $author;
    private ?string $image = null;
    private ?string $description = null;
    private bool $available;

    // private int $sellerId;

    /**
     * Getter pour le titre.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter pour le titre.
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter pour l'auteur.
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Setter pour l'auteur.
     *
     * @param string $author
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter pour l'image.
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Setter pour l'image.
     *
     * @param string|null $image
     * @return void
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * Getter pour la description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter pour la description.
     *
     * @param string|null $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter pour la disponibilité à l'échange.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->available;
    }

    /**
     * Setter pour la disponibilité à l'échange.
     *
     * @param bool $available
     * @return void
     */
    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }

    /*
    private int $sellerId;

    public function getSellerId(): int
    {
        return $this->sellerId;
    }

    public function setSellerId(int $sellerId): void
    {
        $this->sellerId = $sellerId;
    }
    */
}