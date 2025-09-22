<?php
// src/Entity/Grade.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\GradeRepository")]
#[ORM\Table(name: "grades")]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "float")]
    private float $value;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $coefficient = 1.0;

    #[ORM\Column(type: "string", length: 100)]
    private string $subject;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $date;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $comments = null;

    #[ORM\ManyToOne(targetEntity: "Student", inversedBy: "grades")]
    #[ORM\JoinColumn(nullable: false)]
    private Student $student;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    // Getters et Setters
    public function getId(): ?int { return $this->id; }
    public function getValue(): float { return $this->value; }
    public function setValue(float $value): self { $this->value = $value; return $this; }
    public function getCoefficient(): ?float { return $this->coefficient; }
    public function setCoefficient(?float $coefficient): self { $this->coefficient = $coefficient; return $this; }
    public function getSubject(): string { return $this->subject; }
    public function setSubject(string $subject): self { $this->subject = $subject; return $this; }
    public function getDate(): \DateTimeInterface { return $this->date; }
    public function setDate(\DateTimeInterface $date): self { $this->date = $date; return $this; }
    public function getComments(): ?string { return $this->comments; }
    public function setComments(?string $comments): self { $this->comments = $comments; return $this; }
    public function getStudent(): Student { return $this->student; }
    public function setStudent(Student $student): self { $this->student = $student; return $this; }

    public function getWeightedValue(): float
    {
        return $this->value * ($this->coefficient ?? 1.0);
    }
}