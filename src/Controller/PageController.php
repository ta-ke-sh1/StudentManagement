<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PageController extends AbstractController
{
    /** 
     * @IsGranted("ROLE_USER")
     */
    #[Route('/homepage', name: 'homepage')]
    public function index(): Response
    {
        $roles = $this->getUser()->getRoles();
        if ($roles != null) {
            if (in_array('ROLE_STUDENT', $roles)) {
                return $this->redirectToRoute('student_role_view');
            }}
        return $this->render('page/index.html.twig');
    }

    #[Route('/guest', name: 'guest')]
    public function Login()
    {
        return $this->render('page/guest_index.html.twig');
    }
}
