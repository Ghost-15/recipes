<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/list', name: 'app_list')]
    public function list(Request $request, EntityManagerInterface $entityManager, PlaylistMediaRepository $playlistMediaRepository, MediaRepository $mediaRepository): Response
    {
        $playlists = $entityManager->getRepository(Playlist::class)->findAll();
        $playlistSubscriptions = $entityManager->getRepository(PlaylistSubscription::class)->findAll();
        $selectedPlaylistId = $request->query->get('selectedPlaylist');
        $medias = [];
        if ($selectedPlaylistId) {
            $playlistMediaArray = $playlistMediaRepository->findAllMediaWhere(['value'=>$selectedPlaylistId]);
            if ($playlistMediaArray) {
                foreach ($playlistMediaArray as $playlistMedia) {
                    $m = $playlistMedia->getMedia();
                    $medias[] = [
                        'id' => $m->getId(),
                        'mediaType' => $m->getMediaType(),
                        'title' => $m->getTitle(),
                        'shortDescription' => $m->getShortDescription(),
                        'longDescription' => $m->getLongDescription(),
                        'releaseDate' => $m->getReleaseDate()->format('Y-m-d'),
                        'coverImage' => $m->getCoverImage()
                    ];
                }
            }
        }

        return $this->render('hub/lists.html.twig', [
            'playlists' => $playlists,
            'playlistSubscriptions' => $playlistSubscriptions,
            'selectedPlaylistId' => $selectedPlaylistId,
            'medias' => $medias,
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
