<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/addRecipe', name: 'app_recipe')]
    public function addRecipe(): Response
    {
        return $this->render('recipe/index.html.twig');
    }
    #[Route('/saveRecipe', name: 'app_save_recipe')]
    public function saveRecipe(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title = $request->query->get('title');
        $description = $request->query->get('description');
        $instruction = $request->query->get('instruction');

        $app = new Recipe();

        $app->setTitle($title);
        $app->setDescription($description);
        $app->setInstruction($instruction);

        try {
            $entityManager->persist($app);
            $entityManager->flush();
            $this->addFlash('succes', "Bien joue Negro");
        } catch (Exception $e){
            $this->addFlash('error', "Il y'a un probleme");
        }
        return new Response('Bien joue Negro');
    }
    #[Route('/modifieRecipe/{value}', name: 'app_modifie_recipe')]
    public function modifieRecipe(string $value): Response
    {
        return $this->render('recipe/modifie.html.twig',[
            'value' => $value,
        ]);
    }
    #[Route('/updateRecipe/{value}', name: 'app_update_recipe')]
    public function updateRecipe(Request $request, EntityManagerInterface $entityManager, string $value): Response
    {
        $title = $request->query->get('title');
        $description = $request->query->get('description');
        $instruction = $request->query->get('instruction');

        $app = $entityManager->getRepository(Recipe::class)->find($value);

        $app->setTitle($title);
        $app->setDescription($description);
        $app->setInstruction($instruction);

        try {
            $entityManager->flush();
            $this->addFlash('succes', "Bien joue Negro");
        } catch (Exception $e){
            $this->addFlash('error', "Il y'a un probleme");
        }
        return new Response('Bien joue Negro');
    }
    #[Route('/deleteRecipe/{value}', name: 'app_delete_recipe')]
    public function deleteRecipe(EntityManagerInterface $entityManager, string $value): Response
    {
        $app = $entityManager->getRepository(Recipe::class)->find($value);

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
