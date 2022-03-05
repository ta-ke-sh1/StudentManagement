<?php

namespace App\Controller;

use App\Entity\SubjectSchedule;
use App\Form\SubjectScheduleType;
use App\Repository\SubjectScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/schedule')]
class SubjectScheduleController extends AbstractController
{
    #[Route('/', name: 'schedule_list')]
    public function scheduleList() {
        $user = $this->getUser();
        $schedules = $this->getDoctrine()->getRepository(SubjectSchedule::class)->findAll();
        return $this->render('subject_schedule/index.html.twig', [
            'schedules' => $schedules, 
            'user' => $user]);
    }

    #[Route('/id/asc', name: 'schedule_id_asc')]
    public function scheduleSortIdAsc(SubjectScheduleRepository $subjectScheduleRepository)
    {
        $user = $this->getUser();
        $subjects = $subjectScheduleRepository->sortByIDAsc();
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
            'user' => $user
        ]);
    }

    #[Route('/id/desc', name: 'schedule_id_desc')]
    public function scheduleSortIdDesc(SubjectScheduleRepository $subjectScheduleRepository)
    {
        $user = $this->getUser();
        $subjects =$subjectScheduleRepository->sortByIDDesc();
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
            'user' =>  $user
        ]);
    }

    #[Route('/{id}', name: 'schedule_detail')]
    public function scheduleDetail($id)
    {
        $user = $this->getUser();
        $schedule = $this->getDoctrine()->getRepository(SubjectSchedule::class)->find($id);
        if ($schedule == null) {
            $this->addFlash('error', "This schedule does not exist!");
            return $this->redirectToRoute("schedule_list");
        }
        return $this->render('subject/detail.html.twig', [
            'schedule' => $schedule,
            'user' => $user
        ]);
    }

    #[Route('/search', name: 'schedule_search')]
    public function scheduleSearch(Request $request, SubjectScheduleRepository $subjectScheduleRepository)
    {
        $user = $this->getUser();
        $keyword = $request->get("keyword");
        $schedules = $subjectScheduleRepository->searchSchedule($keyword);
        return $this->render('subject/index.html.twig', [
            'schedules' => $schedules,
            'user' => $user
        ]);
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/delete/{id}', name: 'schedule_delete')]
    public function scheduleDelete($id)
    {
        $schedule = $this->getDoctrine()->getRepository(SubjectSchedule::class)->find($id);
        if ($schedule == null) {
            $this->addFlash('error', "This schedule does not exist!");
            $this->redirectToRoute("schedule_list");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($schedule);
            $manager->flush();
        }
        return $this->redirectToRoute("schedule_list");
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/add', name: 'schedule_add')]
    public function scheduleAdd(Request $request)
    {
        $user = $this->getUser();
        $schedule = new SubjectSchedule;
        $form = $this->createForm(SubjectScheduleType::class, $schedule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($schedule);
            $manager->flush();
            return $this->redirectToRoute("subject_list");
        } else {
            return $this->renderForm("subject_schedule/add.html.twig", [
                'SubjectForm' => $form,
                'user' => $user
            ]);
        }
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/edit/{id}', name: 'schedule_edit')]
    public function scheduleEdit(Request $request, $id)
    {
        $user = $this->getUser();
        $schedule = $this->getDoctrine()->getRepository(SubjectSchedule::class)->find($id);
        $form = $this->createForm(SubjectType::class, $schedule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($schedule);
            $manager->flush();
            return $this->redirectToRoute("schedule_list");
        } else {
            return $this->renderForm("subject_schedule/add.html.twig", [
                'SubjectForm' => $form,
                'user' => $user
            ]);
        }
    }
}
