<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Repository\CategorieRecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/hub', name: 'app_hub-')]
class HubController extends AbstractController
{
    #[Route('', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        $recipes = $entityManager->getRepository(Recipe::class)->findAll();
        $ingredient = $entityManager->getRepository(Ingredient::class)->findAll();
        return $this->render('hub/index.html.twig', [
            'categories' => $categories,
            'recipes' => $recipes,
            'ingredients' => $ingredient,
        ]);
    }
    #[Route('/categorie/{value}', name: 'app_list')]
    public function list(CategorieRecipeRepository $repository, string $value): Response
    {
        $recipes = [];
            $array = $repository->findAllWhere(['value'=>$value]);
            if ($array) {
                foreach ($array as $cr) {
                    $r = $cr->getRecipe();
                    $recipes[] = [
                        'id' => $r->getId(),
                        'title' => $r->getTitle(),
                        'description' => $r->getDescription(),
                        'instruction' => $r->getInstruction()
                    ];
                }
            }

        return $this->render('hub/categorie.html.twig', [
            'recipes' => $recipes,
        ]);
    }
    #[Route('/detail/{value}', name: 'app_detail')]
    public function detail(EntityManagerInterface $entityManager, string $value): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->findOneBy(['title' => $value]);
        return $this->render('hub/detail.html.twig', [
            'recipe' => $recipe,
        ]);
    }
    #[Route('/profil', name: 'app_profil')]
    public function profil(EntityManagerInterface $entityManager): Response
    {
        return $this->render('hub/profil.html.twig');
    }
}
