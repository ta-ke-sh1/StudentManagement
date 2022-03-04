<?php

namespace App\Controller;

use App\Entity\Subject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/subject')]
class SubjectController extends AbstractController
{
    #[Route('/', name: 'subject_list')]
    public function subjectList()
    {
        $user = $this->getUser();
        $subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
            'user' => $user
        ]);
    }

    #[Route('/{id}', name: 'subject_index')]
    public function subjectDetail($id)
    {
        $user = $this->getUser();
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($subject == null) {
            $this->addFlash('error', "Subject does not exist!");
            return $this->redirectToRoute("subject_list");
        }
        return $this->render('subject/detail.html.twig', [
            'subject' => $subject,
            'user' => $user
        ]);
    }

    #[Route('/delete/{id}', name: 'subject_delete')]
    public function subjectDelete($id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($subject == null) {
            $this->addFlash('error', "Subject does not exist!");
            $this->redirectToRoute("subject_list");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($subject);
            $manager->flush();
        }
        return $this->redirectToRoute("subject_list");
    }

    #[Route('/add', name: 'subject_add')]
    public function subjectAdd(Request $request)
    {
        $user = $this->getUser();
        $subject = new Subject;
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();
            return $this->redirectToRoute("subject_list");
        } else {
            return $this->renderForm("subject/add.html.twig", [
                'SubjectForm' => $form,
                'user' => $user
            ]);
        }
    }

    #[Route('/edit/{id}', name: 'subject_delete')]
    public function subjectEdit(Request $request, $id)
    {
        $user = $this->getUser();
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();
            return $this->redirectToRoute("subject_list");
        } else {
            return $this->renderForm("subject/add.html.twig", [
                'SubjectForm' => $form,
                'user' => $user
            ]);
        }
    }
}
