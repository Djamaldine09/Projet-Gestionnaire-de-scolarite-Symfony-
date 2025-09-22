<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function test(EntityManagerInterface $em): Response
    {
        // Test de récupération des données
        $students = $em->getRepository(Student::class)->findAll();
        $teachers = $em->getRepository(Teacher::class)->findAll();
        
        return $this->render('test/index.html.twig', [
            'student_count' => count($students),
            'teacher_count' => count($teachers),
        ]);
    }
}