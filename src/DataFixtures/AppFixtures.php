<?php
namespace App\DataFixtures;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Classroom;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création des professeurs
        $teachers = [];
        for ($i = 0; $i < 10; $i++) {
            $teacher = new Teacher();
            $teacher->setFirstName($faker->firstName);
            $teacher->setLastName($faker->lastName);
            $teacher->setEmail($faker->email);
            $teacher->setPhone($faker->phoneNumber);
            $teacher->setSpecialization($faker->randomElement(['Mathématiques', 'Français', 'Histoire', 'Sciences', 'Sport']));
            
            $manager->persist($teacher);
            $teachers[] = $teacher;
        }

        // Création des classes
        $classrooms = [];
        $levels = ['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Terminale'];
        
        for ($i = 0; $i < 15; $i++) {
            $classroom = new Classroom();
            $classroom->setName('Classe ' . ($i + 1));
            $classroom->setLevel($faker->randomElement($levels));
            $classroom->setCapacity($faker->numberBetween(20, 30));
            $classroom->setTeacher($faker->randomElement($teachers));
            
            $manager->persist($classroom);
            $classrooms[] = $classroom;
        }

        // Création des étudiants
        $students = [];
        for ($i = 0; $i < 100; $i++) {
            $student = new Student();
            $student->setFirstName($faker->firstName);
            $student->setLastName($faker->lastName);
            $student->setDateOfBirth($faker->dateTimeBetween('-18 years', '-10 years'));
            $student->setGender($faker->randomElement(['M', 'F']));
            $student->setEmail($faker->email);
            $student->setPhone($faker->phoneNumber);
            $student->setAddress($faker->address);
            
            // Ajouter l'étudiant à 1-2 classes aléatoires
            $studentClasses = $faker->randomElements($classrooms, $faker->numberBetween(1, 2));
            foreach ($studentClasses as $classroom) {
                $student->addClassroom($classroom);
            }
            
            $manager->persist($student);
            $students[] = $student;
        }

        // Création des cours
        $courses = [];
        $subjects = ['Mathématiques', 'Français', 'Histoire-Géo', 'SVT', 'Physique-Chimie', 'Anglais', 'EPS'];
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        
        for ($i = 0; $i < 50; $i++) {
            $course = new Course();
            $course->setName($faker->randomElement($subjects));
            $course->setDescription($faker->sentence);
            $course->setStartTime(new \DateTime($faker->numberBetween(8, 16) . ':00:00'));
            $course->setEndTime(new \DateTime($faker->numberBetween(9, 17) . ':00:00'));
            $course->setDayOfWeek($faker->randomElement($days));
            $course->setTeacher($faker->randomElement($teachers));
            $course->setClassroom($faker->randomElement($classrooms));
            
            $manager->persist($course);
            $courses[] = $course;
        }

        $manager->flush();
    }
}