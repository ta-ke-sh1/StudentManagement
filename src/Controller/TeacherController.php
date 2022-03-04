<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/FGW/teacher')]
class TeacherController extends AbstractController
{
    #[Route('/', name: 'teacher_list')]
    public function teacherList()
    {
        $teachers = $this->getDoctrine()->getRepository(Teacher::class)->findAll();
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teachers,
        ]);
    }

    #[Route('/search', name: 'teacher_search')]
    public function teacherSearch(Request $request, TeacherRepository $teacherRepository)
    {
        $keyword = $request->get("keyword");
        $teachers = $teacherRepository->searchTeacher($keyword);
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teachers
        ]);
    }

    #[Route('/id/asc', name: 'teacher_id_asc')]
    public function teacherSortIdAsc(TeacherRepository $teacherRepository)
    
    {
        $teachers = $teacherRepository->sortByIDAsc();
        return $this -> render('teacher/index.html.twig',[
            'teachers' => $teachers
        ]);
    }

    #[Route('/id/desc', name: 'teacher_id_desc')]
    public function teacherSortIdDesc(TeacherRepository $teacherRepository)
    {
        $teachers = $teacherRepository->sortByIDDesc();
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teachers,
        ]);
    }

    #[Route('/name/asc', name: 'teacher_name_asc')]
    public function teacherSortNameAsc(TeacherRepository $teacherRepository)
    {
        $teachers = $teacherRepository->sortByNameAsc();
        return $this->render('teacher/index.html.twig',[
            'teachers' => $teachers
        ]);
    }

    #[Route('/name/desc', name: 'teacher_name_desc')]
    public function teacherSortNameDesc(TeacherRepository $teacherRepository)
    {
        $teachers = $teacherRepository->sortByNameDesc();
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teachers,
        ]);
    }

    #[Route('detail/{id}', name: 'teacher_detail')]
    public function teacherDetail($id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->Find($id);
        
        if ($teacher == null) {
            $this->addFlash('error', "Teacher does not exist!");
            return $this->redirectToRoute("teacher_list");
        }

        return $this->render('teacher/detail.html.twig',[
            'teacher' => $teacher
        ]);
    }

    /**
     *  @IsGranted("ROLE_ADMIN")
     */
    #[Route('/delete/{id}', name: 'teacher_delete')]
    public function teacherDelete($id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        if ($teacher == null) {
            $this->addFlash('error', "Teacher does not exist!");
            $this->redirectToRoute("teacher_list");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($teacher);
            $manager->flush();
        }
        return $this->redirectToRoute("teacher_list");
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/add', name: 'teacher_add')]
    public function teacherAdd(Request $request)
    {
        $teacher = new Teacher;
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();
            return $this->redirectToRoute("teacher_list");
        } else {
            return $this->renderForm("teacher/add.html.twig",[
                'TeacherForm' => $form
            ]);
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/edit/{id}', name: 'teacher_edit')]
    public function teacherEdit(Request $request,$id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();
            return $this->redirectToRoute("teacher_list");
        } else {
            return $this->renderForm("teacher/edit.html.twig",[
                'TeacherForm' => $form
            ]);
        }
    }
}
