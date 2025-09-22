<?php
// src/Entity/Attendance.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\AttendanceRepository")]
#[ORM\Table(name: "attendances")]
class Attendance
{
    public const STATUS_PRESENT = 'present';
    public const STATUS_ABSENT = 'absent';
    public const STATUS_LATE = 'late';
    public const STATUS_EXCUSED = 'excused';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $date;

    #[ORM\Column(type: "string", length: 20)]
    private string $status;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $remarks = null;

    #[ORM\ManyToOne(targetEntity: "Student", inversedBy: "attendances")]
    #[ORM\JoinColumn(nullable: false)]
    private Student $student;

    #[ORM\ManyToOne(targetEntity: "Course")]
    #[ORM\JoinColumn(nullable: false)]
    private Course $course;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->status = self::STATUS_PRESENT;
    }

    // Getters et Setters
    public function getId(): ?int { return $this->id; }
    public function getDate(): \DateTimeInterface { return $this->date; }
    public function setDate(\DateTimeInterface $date): self { $this->date = $date; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getRemarks(): ?string { return $this->remarks; }
    public function setRemarks(?string $remarks): self { $this->remarks = $remarks; return $this; }
    public function getStudent(): Student { return $this->student; }
    public function setStudent(Student $student): self { $this->student = $student; return $this; }
    public function getCourse(): Course { return $this->course; }
    public function setCourse(Course $course): self { $this->course = $course; return $this; }

    public function isPresent(): bool
    {
        return $this->status === self::STATUS_PRESENT;
    }
}