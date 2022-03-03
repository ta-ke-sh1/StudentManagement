<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFGWType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    #[Route('/id/asc', name: 'user_id_asc')]
    public function userSortIdAsc(UserRepository $userRepository)
    {
        $users = $userRepository->sortByIDAsc();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/search', name: 'user_search')]
    public function userSearch(Request $request, UserRepository $userRepository)
    {
        $keyword = $request->get("keyword");
        $users = $userRepository->searchUser($keyword);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/id/desc', name: 'user_id_desc')]
    public function userSortIdDesc(UserRepository $userRepository)
    {
        $users = $userRepository->sortByIDDesc();
        return $this->render('user/index.html.twig', [
            'users' => $users,
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

    #[Route('/edit/', name: 'user_edit')]
    public function userEdit(Request $request, $id)
    {
        $user = $this->getUser();
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
