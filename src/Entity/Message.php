<?php

// Should have the declare(strict_types = 1);

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;
    
    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    public function getId(): ?int // We can drop the nullable option as column ID is populated with a generated value
    {
        return $this->id;
    }

    public function getUuid(): ?string // We can drop the null option as the column does not have in its declaration the option nullable: true
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static // A setter should have void as return type to limit the memory used by PHP
    {
        $this->uuid = $uuid;

        return $this; // we  can drop the return statement
    }

    public function getText(): ?string // We can drop the null option as the column does not have in its declaration the option nullable: true
    {
        return $this->text;
    }

    public function setText(string $text): static // A setter should have void as return type to limit the memory used by PHP
    {
        $this->text = $text;

        return $this; // we  can drop the return statement
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static // A setter should have void as return type to limit the memory used by PHP
    {
        $this->status = $status;

        return $this; // we  can drop the return statement
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): static // A setter should have void as return type to limit the memory used by PHP
    {
        $this->createdAt = $createdAt;
        
        return $this; // we  can drop the return statement
    }
}
