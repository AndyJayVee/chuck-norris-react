<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteJokeRepository")
 */
class FavoriteJoke
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * int
     */
    public const MAXIMUM_AMOUNT_FAVORITES = 10;

    /**
     * @ORM\Column(name="joke_id", type="integer", nullable=false)
     */
    private $joke_id;

    /**
     * @ORM\Column(name="joke", type="string", nullable=false)
     */
    private $joke;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJokeId(): ?int
    {
        return $this->joke_id;
    }

    public function setJokeId(int $joke_id): self
    {
        $this->joke_id = $joke_id;

        return $this;
    }

    public function getJoke(): ?string
    {
        return $this->joke;
    }

    public function setJoke(string $joke): self
    {
        $this->joke = $joke;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
