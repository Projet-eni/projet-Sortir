<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $idEvent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $string;

    /**
     * @ORM\Column(type="time")
     */
    private $timeLength;

    /**
     * @ORM\Column(type="integer")
     */
    private $signNumberMax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventInfo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    public function getString(): ?\DateTimeInterface
    {
        return $this->string;
    }

    public function setString(\DateTimeInterface $string): self
    {
        $this->string = $string;

        return $this;
    }

    public function getTimeLength(): ?\DateTimeInterface
    {
        return $this->timeLength;
    }

    public function setTimeLength(\DateTimeInterface $timeLength): self
    {
        $this->timeLength = $timeLength;

        return $this;
    }

    public function getSignNumberMax(): ?int
    {
        return $this->signNumberMax;
    }

    public function setSignNumberMax(int $signNumberMax): self
    {
        $this->signNumberMax = $signNumberMax;

        return $this;
    }

    public function getEventInfo(): ?string
    {
        return $this->eventInfo;
    }

    public function setEventInfo(string $eventInfo): self
    {
        $this->eventInfo = $eventInfo;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
