<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'bookings')]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    // ---------------- TOUR ----------------
    #[ORM\ManyToOne(targetEntity: Destination::class)]
    #[ORM\JoinColumn(name: 'tour_id', referencedColumnName: 'tour_id', nullable: false)]
    private ?Destination $destination = null;

    // ---------------- USER ----------------
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    // number_of_people
    #[ORM\Column(name: 'number_of_people', type: 'integer')]
    private int $people;

    // booking_date
    #[ORM\Column(name: 'booking_date', type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $date;

    // total_price
    #[ORM\Column(name: 'total_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $price;

    #[ORM\Column(
        type: 'string',
        length: 20,
        options: ['default' => 'pending']
    )]
    private string $status = 'pending';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $message = null;

    // ---------------- Getters & Setters ----------------

    public function getId(): ?int
    {
        return $this->id;
    }

    // Destination
    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(Destination $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    // User
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    // Email
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    // People
    public function getPeople(): int
    {
        return $this->people;
    }

    public function setPeople(int $people): self
    {
        $this->people = $people;
        return $this;
    }

    // Date
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    // Price
    public function getPrice(): float
    {
        return (float) $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = (string) $price;
        return $this;
    }

    // Status
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    // Message
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }
}
