<?php
// src/Controller/HomeController.php

namespace App\Controller;

use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(StudentRepository $studentRepo, TeacherRepository $teacherRepo, ClassroomRepository $classroomRepo): Response
    {
        // PAS de redirection vers le login - accessible à tous
        return $this->render('home/index.html.twig', [
            'student_count' => $studentRepo->count([]),
            'teacher_count' => $teacherRepo->count([]),
            'classroom_count' => $classroomRepo->count([]),
        ]);
    }
}