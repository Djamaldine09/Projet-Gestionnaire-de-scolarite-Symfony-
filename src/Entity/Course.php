<?php
// src/Entity/Course.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\CourseRepository")]
#[ORM\Table(name: "courses")]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "time")]
    private \DateTimeInterface $startTime;

    #[ORM\Column(type: "time")]
    private \DateTimeInterface $endTime;

    #[ORM\Column(type: "string", length: 10)]
    private string $dayOfWeek;

    #[ORM\ManyToOne(targetEntity: "Teacher", inversedBy: "courses")]
    #[ORM\JoinColumn(nullable: false)]
    private Teacher $teacher;

    #[ORM\ManyToOne(targetEntity: "Classroom", inversedBy: "courses")]
    #[ORM\JoinColumn(nullable: false)]
    private Classroom $classroom;

    // Getters et Setters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    public function getStartTime(): \DateTimeInterface { return $this->startTime; }
    public function setStartTime(\DateTimeInterface $startTime): self { $this->startTime = $startTime; return $this; }
    public function getEndTime(): \DateTimeInterface { return $this->endTime; }
    public function setEndTime(\DateTimeInterface $endTime): self { $this->endTime = $endTime; return $this; }
    public function getDayOfWeek(): string { return $this->dayOfWeek; }
    public function setDayOfWeek(string $dayOfWeek): self { $this->dayOfWeek = $dayOfWeek; return $this; }
    public function getTeacher(): Teacher { return $this->teacher; }
    public function setTeacher(Teacher $teacher): self { $this->teacher = $teacher; return $this; }
    public function getClassroom(): Classroom { return $this->classroom; }
    public function setClassroom(Classroom $classroom): self { $this->classroom = $classroom; return $this; }

    public function getDuration(): string
    {
        $interval = $this->startTime->diff($this->endTime);
        return $interval->format('%H:%I');
    }
}