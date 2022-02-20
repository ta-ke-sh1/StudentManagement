<?php

namespace App\Controller;

use App\Entity\Grade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/grade')]
class GradeController extends AbstractController
{
    #[Route('/', name: 'grade_list')]
    public function gradeList()
    {
        $grades = $this->getDoctrine()->getRepository(Grade::class)->findAll();
        return $this->render('grade/index.html.twig', [
            'grades' => $grades,
        ]);
    }

    #[Route('/{id}', name: 'grade_index')]
    public function gradeDetail($id)
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);
        if ($grade == null) {
            $this->addFlash('error', "Grade does not exist!");
            return $this->redirectToRoute("grade_list");
        }
        return $this->render('grade/detail.html.twig', [
            'grade' => $grade,
        ]);
    }

    #[Route('/delete/{id}', name: 'grade_delete')]
    public function gradeDelete($id)
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);
        if ($grade == null) {
            $this->addFlash('error', "Grade does not exist!");
            $this->redirectToRoute("grade_list");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($grade);
            $manager->flush();
        }
        return $this->redirectToRoute("grade_list");
    }

    #[Route('/add', name: 'grade_add')]
    public function gradeAdd(Request $request)
    {
        $grade = new Grade;
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($grade);
            $manager->flush();
            return $this->redirectToRoute("grade_list");
        } else {
            return $this->renderForm("grade/add.html.twig", [
                'GradeForm' => $form
            ]);
        }
    }

    #[Route('/edit/{id}', name: 'grade_delete')]
    public function gradeEdit(Request $request, $id)
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($grade);
            $manager->flush();
            return $this->redirectToRoute("grade_list");
        } else {
            return $this->renderForm("grade/add.html.twig", [
                'GradeForm' => $form
            ]);
        }
    }
}
