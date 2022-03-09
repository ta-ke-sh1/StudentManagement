<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentEditType;
use App\Repository\GradeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class StudentViewController extends AbstractController
{
    #[Route('/student/homepage', name: 'student_role_view')]
    public function studentRoleView(AuthenticationUtils $authenticationUtils, GradeRepository $gradeRepository)
    {
        $user = $this->getUser();
        if ($user->getStudent() == null) {
            $this->addFlash("Error", "Unlinked account, please contact admin!");
            return $this->redirectToRoute("app_login");
        } else $student = $this->getDoctrine()->getRepository(Student::class)->find($user->getStudent()->getId());

        $ongoing = $gradeRepository->searchOngoingClasses($student->getId());
        $grades = $gradeRepository->searchGrades($student->getId());
        $sum = 0;

        foreach ($grades as $g) {
            $sum += $g->getNumberGrade();
        }
        if (count($grades) > 0) {
            $gpa = $sum / count($grades);
        } else $gpa = 0;

        return $this->render('student/detail.html.twig', [
            'student' => $student,
            'grades' => $grades,
            'ongoing' => $ongoing,
            'gpa' => $gpa,
            'user' => $user
        ]);
    }
}
