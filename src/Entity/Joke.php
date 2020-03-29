<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteJokeRepository")
 */
class Joke
{
    /**
     * @ORM\Column(name="joke_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $joke_id;

    /**
     * @ORM\Column(name="joke", type="string", nullable=false)
     */
    private $joke;

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


}
