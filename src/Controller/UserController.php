<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFGWType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/** 
 * @IsGranted("ROLE_ADMIN")
 */
#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_list')]
    public function userList()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            "users" => $users
        ]);
    }

    #[Route('/information', name: 'user_information')]
    public function userCurrent()
    {
        $user = $this->getUser();
        return $this->render('user/index.html.twig', [
            "user" => $user
        ]);
    }

    #[Route('/{id}', name: 'user_detail')]
    public function userDetail($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('user/index.html.twig', [
            "user" => $user
        ]);
    }

    #[Route('/add', name: 'user_add')]
    public function userAdd(Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            "user" => $user
        ]);
    }

    #[Route('/edit/{id}', name: 'user_edit')]
    public function userEdit(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('user/index.html.twig', [
            "user" => $user
        ]);
    }

    #[Route('/delete', name: 'user_delete')]
    public function userDelete(Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            "user" => $user
        ]);
    }
}
