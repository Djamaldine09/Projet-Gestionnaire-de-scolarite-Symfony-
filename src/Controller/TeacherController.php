<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\Teacher1Type;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher')]
final class TeacherController extends AbstractController
{
    #[Route(name: 'app_teacher_index', methods: ['GET'])]
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_teacher_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(Teacher1Type::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($teacher);
            $entityManager->flush();

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teacher_show', methods: ['GET'])]
    public function show(Teacher $teacher): Response
    {
        return $this->render('teacher/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_teacher_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Teacher $teacher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Teacher1Type::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teacher_delete', methods: ['POST'])]
    public function delete(Request $request, Teacher $teacher, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($teacher);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
    }
}
