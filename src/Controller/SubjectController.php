<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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

    #[Route('/search', name: 'subject_search')]
    public function subjectSearch(Request $request, SubjectRepository $subjectRepository)
    {
        $user = $this->getUser();
        $keyword = $request->get("keyword");
        $subjects = $subjectRepository->searchSubject($keyword);
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
            'user' => $user
        ]);
    }

    #[Route('/id/asc', name: 'subject_id_asc')]
    public function subjectSortIdAsc(SubjectRepository $subjectRepository)
    {
        $user = $this->getUser();
        $subjects = $subjectRepository->sortByIDAsc();
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
            'user' => $user
        ]);
    }

    #[Route('/id/desc', name: 'subject_id_desc')]
    public function subjectSortIdDesc(SubjectRepository $subjectRepository)
    {
        $user = $this->getUser();
        $subjects =$subjectRepository->sortByIDDesc();
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
            'user' =>  $user
        ]);
    }

    #[Route('/name/asc', name: 'subject_name_asc')]
    public function subjectSortNameAsc(SubjectRepository $subjectRepository)
    {
        $user = $this->getUser();
        $subjects = $subjectRepository->sortByNameAsc();
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
            'user' => $user
        ]);
    }

    #[Route('/name/desc', name: 'subject_name_desc')]
    public function subjectSortNameDesc(SubjectRepository $subjectRepository)
    {
        $user = $this->getUser();
        $subjects = $subjectRepository->sortByNameDesc();
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

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
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

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
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

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/edit/{id}', name: 'subject_edit')]
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
