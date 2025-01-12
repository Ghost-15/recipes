<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient')]
    public function index(): Response
    {
        return $this->render('ingredient/index.html.twig');
    }
    #[Route('/saveIngredient', name: 'app_save_ingredient')]
    public function saveIngredient(Request $request, EntityManagerInterface $entityManager): Response
    {
        $name = $request->query->get('name');

        $app = new Ingredient();

        $app->setName($name);

        try {
            $entityManager->persist($app);
            $entityManager->flush();
            $this->addFlash('succes', "Bien joue Negro");
        } catch (Exception $e){
            $this->addFlash('error', "Il y'a un probleme");
        }
        return new Response('Bien joue Negro');
    }
    #[Route('/modifieIngredient/{value}', name: 'app_modifie_ingredient')]
    public function modifieRecipe(string $value): Response
    {
        return $this->render('ingredient/modifie.html.twig',[
            'value' => $value,
        ]);
    }
    #[Route('/updateIngredient', name: 'app_update_ingredient')]
    public function updateRecipe(Request $request, EntityManagerInterface $entityManager, string $value): Response
    {
        $name = $request->query->get('name');

        $app = $entityManager->getRepository(Ingredient::class)->find($value);

        $app->setName($name);

        try {
            $entityManager->flush();
            $this->addFlash('succes', "Bien joue Negro");
        } catch (Exception $e){
            $this->addFlash('error', "Il y'a un probleme");
        }
        return new Response('Bien joue Negro');
    }
    #[Route('/deleteIngredient/{value}', name: 'app_delete_recipe')]
    public function deleteRecipe(EntityManagerInterface $entityManager, string $value): Response
    {
        $app = $entityManager->getRepository(Ingredient::class)->find($value);

        try {
            $entityManager->remove($app);
            $entityManager->flush();
            $this->addFlash('succes', "Bien joue Negro");
        } catch (Exception $e){
            $this->addFlash('error', "Il y'a un probleme");
        }
        return new Response('Bien joue Negro');
    }
}
