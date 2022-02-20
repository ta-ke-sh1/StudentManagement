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
        $classFGWs = $this->getDoctrine()->getRepository(ClassFGW::class)->findAll();
        return $this->render('classFGW/index.html.twig', [
            'classFGWs' => $classFGWs,
        ]);
    }

    #[Route('/{id}', name: 'classFGW_index')]
    public function classFGWDetail($id)
    {
        $classFGW = $this->getDoctrine()->getRepository(ClassFGW::class)->find($id);
        if ($classFGW == null) {
            $this->addFlash('error', "ClassFGW does not exist!");
            return $this->redirectToRoute("classFGW_list");
        }
        return $this->render('classFGW/detail.html.twig', [
            'classFGW' => $classFGW,
        ]);
    }

    #[Route('/delete/{id}', name: 'classFGW_delete')]
    public function classFGWDelete($id)
    {
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
                'ClassFGWForm' => $form
            ]);
        }
    }

    #[Route('/edit/{id}', name: 'classFGW_delete')]
    public function classFGWEdit(Request $request, $id)
    {
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
                'ClassFGWForm' => $form
            ]);
        }
    }
}
