<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/mdpO', name: 'app_mdpO')]
    public function mdpO(EntityManagerInterface $entityManager): Response
    {
        return $this->render('security/mdpO.html.twig');
    }
    #[Route('/saveUser', name: 'app_save_user')]
    public function saveUser(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $username = $request->query->get('username');
        $email = $request->query->get('email');
        $password = $request->query->get('password');
        $role = $request->query->get('password');

        $app = new User();

        $app->setUsername($username);
        $app->setEmail($email);
        $app->setPassword($passwordHasher->hashPassword($app, $password));
        $app->setRoles((array)$role);

        try {
            $entityManager->persist($app);
            $entityManager->flush();
            $this->addFlash('succes', "Bien joue Negro");
        } catch (Exception $e){
            $this->addFlash('error', "Il y'a un probleme");
        }
        return new Response('Bien joue Negro');    }
    #[Route('/mdpR', name: 'app_mdpR')]
    public function mdpR(): Response
    {
        return $this->render('security/mdpR.html.twig');
    }
    #[Route('/update-password', name:'app_updateO')]
    public function updatePassword(Request $request, EntityManagerInterface $entityManager,
                                   UserPasswordHasherInterface $passwordHasher, Security $security): Response
    {
        $newPassword = $request->request->get('pswd');
        $user = $security->getUser();

        if ($newPassword) {
            $user->setPassword($passwordHasher->hashPassword($user, $newPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Password updated successfully!');
        } else {
            $this->addFlash('error', 'Please provide a valid password.');
        }
        return $this->redirectToRoute('app_hub-app_profil');
    }
}
