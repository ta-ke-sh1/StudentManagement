<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\GradeRepository;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/student')]
class StudentController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/', name: 'student_list')]
    public function studentList()
    {
        $user = $this->getUser();
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/search', name: 'student_search')]
    public function studentSearch(Request $request, StudentRepository $studentRepository)
    {
        $user = $this->getUser();
        $keyword = $request->get("keyword");
        $students = $studentRepository->searchStudent($keyword);
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/id/asc', name: 'student_id_asc')]
    public function studentSortIdAsc(StudentRepository $studentRepository)
    {
        $user = $this->getUser();
        $students = $studentRepository->sortByIDAsc();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/id/desc', name: 'student_id_desc')]
    public function studentSortIdDesc(StudentRepository $studentRepository)
    {
        $user = $this->getUser();
        $students = $studentRepository->sortByIDDesc();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'user' =>  $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/name/asc', name: 'student_name_asc')]
    public function studentSortNameAsc(StudentRepository $studentRepository)
    {
        $user = $this->getUser();
        $students = $studentRepository->sortByNameAsc();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/name/desc', name: 'student_name_desc')]
    public function studentSortNameDesc(StudentRepository $studentRepository)
    {
        $user = $this->getUser();
        $students = $studentRepository->sortByNameDesc();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'user' => $user
        ]);
    }

    #[Route('/detail/{id}', name: 'student_detail')]
    public function studentDetail($id, GradeRepository $gradeRepository)
    {
        $user = $this->getUser();
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $grades = $gradeRepository->searchGrades($student->getId());
        $ongoing = $gradeRepository->searchOngoingClasses($student->getId());
        $sum = 0;
        foreach ($grades as $g) {
            $sum += $g->getNumberGrade();
        }
        if (count($grades) > 0) {
            $gpa = $sum / count($grades);
        } else $gpa = 0;

        if ($student == null) {
            $this->addFlash('error', "Student does not exist!");
            return $this->redirectToRoute("student_list");
        }
        return $this->render('student/detail.html.twig', [
            'student' => $student,
            'grades' => $grades,
            'ongoing' => $ongoing,
            'gpa' => $gpa,
            'user' => $user
        ]);
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
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

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/add', name: 'student_add')]
    public function studentAdd(Request $request)
    {
        $user = $this->getUser();
        $student = new Student;
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Xu ly ten & duong dan cua anh
            // B1: lay ten anh tu file upload
            $image = $student->getImage();
            // B2: dat ten moi cho file anh 
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
            // B3: lay duoi ten anh
            $imgExtension = $image->guessExtension();
            // B4: Merge ten va duoi anh
            $imgName = $imgName . '.' . $imgExtension;
            // B5: Copy anh vao thu muc chi dinh
            try {
                $image->move(
                    $this->getParameter('student_image'), // Tiep tuc edit trong services.yaml trong folder config
                    $imgName
                );
            } catch (FileException $e) {
                throw $e;
            }

            // B6: Luu ten anh vao DB
            $student->setImage($imgName);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute("student_list");
        } else {
            return $this->renderForm("student/add.html.twig", [
                'StudentForm' => $form,
                'user' => $user
            ]);
        }
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/edit/{id}', name: 'student_edit')]
    public function studentEdit(Request $request, $id, UserRepository $userRepository)
    {
        $user = $this->getUser();
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
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
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("student_list");
        } else {
            return $this->renderForm("student/edit.html.twig", [
                'StudentForm' => $form,
                'user' => $user
            ]);
        }
    }
}
