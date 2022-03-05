<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_list')]
    public function userList()
    {
        $user = $this->getUser();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            "users" => $users,
            "user" => $user
        ]);
    }
    #[Route('/id/asc', name: 'user_id_asc')]
    public function userSortIdAsc(UserRepository $userRepository)
    {
        $user = $this->getUser();
        $users = $userRepository->sortByIDAsc();
        return $this->render('user/index.html.twig', [
            'users' => $users,
            "user" => $user
        ]);
    }

    #[Route('/search', name: 'user_search')]
    public function userSearch(Request $request, UserRepository $userRepository)
    {
        $user = $this->getUser();
        $keyword = $request->get("keyword");
        $users = $userRepository->searchUser($keyword);
        return $this->render('user/index.html.twig', [
            'users' => $users,
            "user" => $user
        ]);
    }

    #[Route('/id/desc', name: 'user_id_desc')]
    public function userSortIdDesc(UserRepository $userRepository)
    {
        $user = $this->getUser();
        $users = $userRepository->sortByIDDesc();
        return $this->render('user/index.html.twig', [
            'users' => $users,
            "user" => $user
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

    #[Route('/add/newUser', name: 'user_add')]
    public function userAddAnother(Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $this->getUser();
        $newUser = new User;
        $form = $this->createForm(UserType::class, $newUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Xu ly ten & duong dan cua anh
            // B1: lay du lieu anh tu form
            $file = $form['avatar']->getData();
            // B2: check xem du lieu anh null hay k
            if ($file != null) {
                $image = $newUser->getAvatar();
                $id = uniqid();
                $imgName = $newUser->getUsername() . $id;
                $imgExtension = $image->guessExtension();
                $imgName = $imgName . '.' . $imgExtension;
                try {
                    $image->move(
                        $this->getParameter('user_image'), // Tiep tuc edit trong services.yaml trong folder config
                        $imgName
                    );
                } catch (FileException $e) {
                    throw $e;
                }
                $newUser->setImage($imgName);
            }

            $newUser->setPassword(
                $userPasswordHasher->hashPassword(
                    $newUser,
                    $form->get('plainPassword')->getData()
                )
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newUser);
            $manager->flush();
            return $this->redirectToRoute("user_list");
        } else {
            return $this->renderForm("user/add.html.twig", [
                'Form' => $form,
                "user" => $user
            ]);
        }
    }

    #[Route('/edit/{id}', name: 'user_edit')]
    public function userEdit(Request $request, $id, UserPasswordHasherInterface $userPasswordHasher)
    {
        $userMain = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Xu ly ten & duong dan cua anh
            // B1: lay du lieu anh tu form
            $file = $form['avatar']->getData();
            // B2: check xem du lieu anh null hay k
            if ($file != null) {
                $image = $user->getAvatar();
                $id = uniqid();
                $imgName = $user->getName() . $id;
                $imgExtension = $image->guessExtension();
                $imgName = $imgName . '.' . $imgExtension;
                try {
                    $image->move(
                        $this->getParameter('user_image'), // Tiep tuc edit trong services.yaml trong folder config
                        $imgName
                    );
                } catch (FileException $e) {
                    throw $e;
                }
                $user->setImage($imgName);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $roles = $user->getRoles();

            if ($roles != null) {
                if (in_array('ROLE_STUDENT', $roles)) {
                    return $this->redirectToRoute('student_role_view');
                }
            }
            return $this->redirectToRoute("homepage");
        }
        return $this->renderForm("user/edit.html.twig", [
            'UserForm' => $form,
            'user' => $userMain
        ]);
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/delete/{id}', name: 'user_delete')]
    public function userDelete($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user == null) {
            $this->addFlash('error', "User does not exist!");
            $this->redirectToRoute("user_list");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($user);
            $manager->flush();
        }
        return $this->redirectToRoute("user_list");
    }
}
