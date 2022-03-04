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
            'gpa' => $gpa
        ]);
    }

    #[Route('/student/editInformation', name: 'student_self_edit')]
    public function studentEdit(Request $request)
    {
        $user = $this->getUser();
        $student = $this->getDoctrine()->getRepository(Student::class)->find($user->getStudent()->getId());
        $form = $this->createForm(StudentEditType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Xu ly ten & duong dan cua anh
            // B1: lay du lieu anh tu form
            $file = $form['image']->getData();
            // B2: check xem du lieu anh null hay k
            if ($file != null) {
                $image = $student->getImage();
                $prefix = $student->getMajor();
                if ($prefix == "Computing") {
                    $prefix = "GCH";
                } else if ($prefix == "Design") {
                    $prefix = "GDH";
                } else if ($prefix == "Business") {
                    $prefix = "GBH";
                } else {
                    $prefix = "GMH";
                }
                $id = uniqid();
                $imgName = $student->getName() . $prefix . $id;
                $imgExtension = $image->guessExtension();
                $imgName = $imgName . '.' . $imgExtension;
                try {
                    $image->move(
                        $this->getParameter('student_image'), // Tiep tuc edit trong services.yaml trong folder config
                        $imgName
                    );
                } catch (FileException $e) {
                    throw $e;
                }
                $student->setImage($imgName);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute("student_role_view");
        } else {
            return $this->renderForm("student_view/edit.html.twig", [
                'StudentEditForm' => $form,
                'student' => $student
            ]);
        }
    }
}
