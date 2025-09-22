<?php
// src/Entity/Student.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: "App\Repository\StudentRepository")]
#[ORM\Table(name: "students")]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $firstName;

    #[ORM\Column(type: "string", length: 100)]
    private string $lastName;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $dateOfBirth;

    #[ORM\Column(type: "string", length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(type: "string", length: 200, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $updatedAt;

    #[ORM\ManyToMany(targetEntity: "Classroom", mappedBy: "students")]
    private Collection $classrooms;

    #[ORM\OneToMany(targetEntity: "Grade", mappedBy: "student")]
    private Collection $grades;

    #[ORM\OneToMany(targetEntity: "Attendance", mappedBy: "student")]
    private Collection $attendances;

    public function __construct()
    {
        $this->classrooms = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->attendances = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    // Getters et Setters
    public function getId(): ?int { return $this->id; }
    public function getFirstName(): string { return $this->firstName; }
    public function setFirstName(string $firstName): self { $this->firstName = $firstName; return $this; }
    public function getLastName(): string { return $this->lastName; }
    public function setLastName(string $lastName): self { $this->lastName = $lastName; return $this; }
    public function getDateOfBirth(): \DateTimeInterface { return $this->dateOfBirth; }
    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self { $this->dateOfBirth = $dateOfBirth; return $this; }
    public function getGender(): ?string { return $this->gender; }
    public function setGender(?string $gender): self { $this->gender = $gender; return $this; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }
    public function getAddress(): ?string { return $this->address; }
    public function setAddress(?string $address): self { $this->address = $address; return $this; }
    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
    public function getUpdatedAt(): \DateTimeInterface { return $this->updatedAt; }
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getAge(): int
    {
        return $this->dateOfBirth->diff(new \DateTime())->y;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->classrooms->contains($classroom)) {
            $this->classrooms[] = $classroom;
            $classroom->addStudent($this);
        }
        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        if ($this->classrooms->removeElement($classroom)) {
            $classroom->removeStudent($this);
        }
        return $this;
    }

    public function getClassrooms(): Collection { return $this->classrooms; }
    public function getGrades(): Collection { return $this->grades; }
    public function getAttendances(): Collection { return $this->attendances; }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function addGrade(Grade $grade): static
    {
        if (!$this->grades->contains($grade)) {
            $this->grades->add($grade);
            $grade->setStudent($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): static
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getStudent() === $this) {
                $grade->setStudent(null);
            }
        }

        return $this;
    }

    public function addAttendance(Attendance $attendance): static
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances->add($attendance);
            $attendance->setStudent($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): static
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getStudent() === $this) {
                $attendance->setStudent(null);
            }
        }

        return $this;
    }
}