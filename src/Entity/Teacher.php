<?php
// src/Entity/Teacher.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: "App\Repository\TeacherRepository")]
#[ORM\Table(name: "teachers")]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $firstName;

    #[ORM\Column(type: "string", length: 100)]
    private string $lastName;

    #[ORM\Column(type: "string", length: 200, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $specialization = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $hireDate;

    #[ORM\OneToMany(targetEntity: "Classroom", mappedBy: "teacher")]
    private Collection $classrooms;

    #[ORM\OneToMany(targetEntity: "Course", mappedBy: "teacher")]
    private Collection $courses;

    public function __construct()
    {
        $this->classrooms = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->hireDate = new \DateTime();
    }

    // Getters et Setters
    public function getId(): ?int { return $this->id; }
    public function getFirstName(): string { return $this->firstName; }
    public function setFirstName(string $firstName): self { $this->firstName = $firstName; return $this; }
    public function getLastName(): string { return $this->lastName; }
    public function setLastName(string $lastName): self { $this->lastName = $lastName; return $this; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }
    public function getSpecialization(): ?string { return $this->specialization; }
    public function setSpecialization(?string $specialization): self { $this->specialization = $specialization; return $this; }
    public function getHireDate(): \DateTimeInterface { return $this->hireDate; }
    public function setHireDate(\DateTimeInterface $hireDate): self { $this->hireDate = $hireDate; return $this; }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->classrooms->contains($classroom)) {
            $this->classrooms[] = $classroom;
            $classroom->setTeacher($this);
        }
        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        if ($this->classrooms->removeElement($classroom)) {
            $classroom->setTeacher(null);
        }
        return $this;
    }

    public function getClassrooms(): Collection { return $this->classrooms; }
    public function getCourses(): Collection { return $this->courses; }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setTeacher($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getTeacher() === $this) {
                $course->setTeacher(null);
            }
        }

        return $this;
    }
}