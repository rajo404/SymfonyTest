<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Team;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private ?int $id = null;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private ?string $firstName = null;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private ?string $lastName = null;

    /**
    * @ORM\ManyToOne(targetEntity=Team::class)
    * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
    */
    private ?Team $team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }
}
