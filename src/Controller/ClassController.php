<?php

namespace App\Controller;

use App\Entity\ClassFGW;
use App\Form\ClassType;
use App\Repository\ClassFGWRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/class')]
class ClassController extends AbstractController
{
    #[Route('/', name: 'classFGW_list')]
    public function classFGWList()
    {
        $user = $this->getUser();
        $classFGWs = $this->getDoctrine()->getRepository(ClassFGW::class)->findAll();
        return $this->render('classFGW/index.html.twig', [
            'classFGWs' => $classFGWs,
            'user' => $user
        ]);
    }

    #[Route('/search', name: 'classFGW_search')]
    public function classFGWSearch(Request $request, ClassFGWRepository $classFGWRepository)
    {
        $user = $this->getUser();
        $keyword = $request->get("keyword");
        $classFGWs = $classFGWRepository->searchStudent($keyword);
        return $this->render('classFGW/index.html.twig', [
            'classFGWs' => $classFGWs,
            'user' => $user
        ]);
    }

    #[Route('/id/asc', name: 'classFGW_id_asc')]
    public function classFGWSortIdAsc(ClassFGWRepository $classFGWRepository)
    {
        $user = $this->getUser();
        $classFGWs = $classFGWRepository->sortByIDAsc();
        return $this -> render('classFGW/index.html.twig',[
            'classFGWs' => $classFGWs,
            'user' => $user
        ]);
    }

    #[Route('/id/desc', name: 'classFGW_id_desc')]
    public function classFGWSortIdDesc(ClassFGWRepository $classFGWRepository)
    {
        $user = $this->getUser();
        $classFGWs = $classFGWRepository->sortByIDDesc();
        return $this->render('classFGW/index.html.twig', [
            'classFGWs' => $classFGWs,
            'user' => $user
        ]);
    }

    #[Route('/name/asc', name: 'classFGW_name_asc')]
    public function classFGWSortNameAsc(ClassFGWRepository $classFGWRepository)
    {
        $user = $this->getUser();
        $classFGWs = $classFGWRepository->sortByNameAsc();
        return $this->render('classFGW/index.html.twig',[
            'classFGWs' => $classFGWs,
            'user' => $user
        ]);
    }

    #[Route('/name/desc', name: 'classFGW_name_desc')]
    public function classFGWSortNameDesc(ClassFGWRepository $classFGWRepository)
    {
        $user = $this->getUser();
        $classFGWs = $classFGWRepository->sortByNameDesc();
        return $this->render('classFGW/index.html.twig', [
            'classFGWs' => $classFGWs,
            'user' => $user
        ]);
    }

    #[Route('/{id}', name: 'classFGW_detail')]
    public function classFGWDetail($id)
    {
        $user = $this->getUser();
        $classFGW = $this->getDoctrine()->getRepository(ClassFGW::class)->find($id);
        if ($classFGW == null) {
            $this->addFlash('error', "ClassFGW does not exist!");
            return $this->redirectToRoute("classFGW_list");
        }
        return $this->render('classFGW/detail.html.twig', [
            'classFGW' => $classFGW,
            'user' => $user
        ]);
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/delete/{id}', name: 'classFGW_delete')]
    public function classFGWDelete($id)
    {
        $user = $this->getUser();
        $classFGW = $this->getDoctrine()->getRepository(ClassFGW::class)->find($id);
        if ($classFGW == null) {
            $this->addFlash('error', "ClassFGW does not exist!");
            $this->redirectToRoute("classFGW_list");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($classFGW);
            $manager->flush();
        }
        return $this->redirectToRoute("classFGW_list");
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/add/class', name: 'classFGW_add')]
    public function classFGWAdd(Request $request)
    {
        $user = $this->getUser();
        $classFGW = new ClassFGW;
        $form = $this->createForm(ClassType::class, $classFGW);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($classFGW);
            $manager->flush();
            return $this->redirectToRoute("classFGW_list");
        } else {
            return $this->renderForm("classFGW/add.html.twig", [
                'ClassFGWForm' => $form,
                'user' => $user
            ]);
        }
    }
    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/edit/{id}', name: 'classFGW_edit')]
    public function classFGWEdit(Request $request, $id)
    {
        $user = $this->getUser();
        $classFGW = $this->getDoctrine()->getRepository(ClassFGW::class)->find($id);
        $form = $this->createForm(ClassType::class, $classFGW);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($classFGW);
            $manager->flush();
            return $this->redirectToRoute("classFGW_list");
        } else {
            return $this->renderForm("classFGW/add.html.twig", [
                'ClassFGWForm' => $form,
                'user' => $user
            ]);
        }
    }
}
