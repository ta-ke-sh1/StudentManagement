<?php

namespace App\Controller;

use App\Entity\ClassFGW;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/{id}', name: 'classFGW_index')]
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

    #[Route('/add', name: 'classFGW_add')]
    public function classFGWAdd(Request $request)
    {
        $user = $this->getUser();
        $classFGW = new ClassFGW;
        $form = $this->createForm(ClassFGWType::class, $classFGW);
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

    #[Route('/edit/{id}', name: 'classFGW_delete')]
    public function classFGWEdit(Request $request, $id)
    {
        $user = $this->getUser();
        $classFGW = $this->getDoctrine()->getRepository(ClassFGW::class)->find($id);
        $form = $this->createForm(ClassFGWType::class, $classFGW);
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
