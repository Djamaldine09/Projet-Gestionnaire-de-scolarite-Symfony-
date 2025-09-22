<?php
// src/Entity/Classroom.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: "App\Repository\ClassroomRepository")]
#[ORM\Table(name: "classrooms")]
class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50)]
    private string $name;

    #[ORM\Column(type: "string", length: 10)]
    private string $level;

    #[ORM\Column(type: "integer")]
    private int $capacity;

    #[ORM\ManyToOne(targetEntity: "Teacher", inversedBy: "classrooms")]
    #[ORM\JoinColumn(nullable: true)]
    private ?Teacher $teacher = null;

    #[ORM\ManyToMany(targetEntity: "Student", inversedBy: "classrooms")]
    #[ORM\JoinTable(name: "classroom_student")]
    private Collection $students;

    #[ORM\OneToMany(targetEntity: "Course", mappedBy: "classroom")]
    private Collection $courses;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    // Getters et Setters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getLevel(): string { return $this->level; }
    public function setLevel(string $level): self { $this->level = $level; return $this; }
    public function getCapacity(): int { return $this->capacity; }
    public function setCapacity(int $capacity): self { $this->capacity = $capacity; return $this; }
    public function getTeacher(): ?Teacher { return $this->teacher; }
    public function setTeacher(?Teacher $teacher): self { $this->teacher = $teacher; return $this; }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
        }
        return $this;
    }

    public function removeStudent(Student $student): self
    {
        $this->students->removeElement($student);
        return $this;
    }

    public function getStudents(): Collection { return $this->students; }
    public function getCourses(): Collection { return $this->courses; }

    public function getStudentCount(): int
    {
        return $this->students->count();
    }

    public function isFull(): bool
    {
        return $this->students->count() >= $this->capacity;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setClassroom($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getClassroom() === $this) {
                $course->setClassroom(null);
            }
        }

        return $this;
    }
}