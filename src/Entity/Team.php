<?php

namespace App\Entity;

use App\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeamRepository;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private ?int $id;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private ?string $name;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private ?string $country;

    /**
    * @ORM\Column(type="decimal", precision=10, scale=2)
    */
    private ?string $balance;

    /**
    * @ORM\ManyToOne(targetEntity=Player::class)
    * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
    */
    private ?Player $player;

    public function __construct()
    {
        $this->id = null;
        $this->name = null;
        $this->country = null;
        $this->balance = null;
        $this->player = null;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
