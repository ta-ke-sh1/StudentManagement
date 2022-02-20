<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'student_list')]
    public function studentList()
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/{id}', name: 'student_index')]
    public function studentDetail($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('error', "Student does not exist!");
            return $this->redirectToRoute("student_list");
        }
        return $this->render('student/detail.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/delete/{id}', name: 'student_delete')]
    public function studentDelete($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('error', "Student does not exist!");
            $this->redirectToRoute("student_list");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($student);
            $manager->flush();
        }
        return $this->redirectToRoute("student_list");
    }

    #[Route('/add', name: 'student_add')]
    public function studentAdd(Request $request)
    {
        $student = new Student;
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute("student_list");
        } else {
            return $this->renderForm("student/add.html.twig", [
                'StudentForm' => $form
            ]);
        }
    }

    #[Route('/edit/{id}', name: 'student_delete')]
    public function studentEdit(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute("student_list");
        } else {
            return $this->renderForm("student/add.html.twig", [
                'StudentForm' => $form
            ]);
        }
    }
}
