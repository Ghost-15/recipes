<?php

namespace App\Controller;

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
