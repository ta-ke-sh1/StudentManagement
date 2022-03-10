<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Teacher;
use App\Entity\ClassFGW;
use App\Entity\SubjectSchedule;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /** 
     * @IsGranted("ROLE_USER")
     */
    #[Route('/homepage', name: 'homepage')]
    public function index(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        $teachers = $this->getDoctrine()->getRepository(Teacher::class)->findAll();
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        $classes = $this->getDoctrine()->getRepository(ClassFGW::class)->findAll();
        $subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();
        $schedules = $this->getDoctrine()->getRepository(SubjectSchedule::class)->findAll();
        if ($roles != null) {
            if (in_array('ROLE_STUDENT', $roles)) {
                return $this->redirectToRoute('student_role_view');
            }
            if (in_array('ROLE_TEACHER', $roles)) {
                return $this->redirectToRoute('teacher_list');
            } 
        }
        return $this->render('page/index.html.twig', [
            'user' => $user,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'classes' => $classes,
            'students' => $students,
            'schedules' => $schedules
        ]);
    }

    #[Route('/guest', name: 'guest')]
    public function Login()
    {
        return $this->render('page/guest_index.html.twig');
    }
}
