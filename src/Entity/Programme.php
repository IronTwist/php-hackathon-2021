<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammeRepository::class)
 */
class Programme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $room;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_participants;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_programme;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_programme;

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

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(int $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getMaxParticipants(): ?int
    {
        return $this->max_participants;
    }

    public function setMaxParticipants(int $max_participants): self
    {
        $this->max_participants = $max_participants;

        return $this;
    }

    public function getStartProgramme(): ?\DateTimeInterface
    {
        return $this->start_programme;
    }

    public function setStartProgramme(\DateTimeInterface $start_programme): self
    {
        $this->start_programme = $start_programme;

        return $this;
    }

    public function getEndProgramme(): ?\DateTimeInterface
    {
        return $this->end_programme;
    }

    public function setEndProgramme(\DateTimeInterface $end_programme): self
    {
        $this->end_programme = $end_programme;

        return $this;
    }
}
