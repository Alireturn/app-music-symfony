<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Music;
use App\Entity\Category;
use App\Entity\Favorite;
use Doctrine\ORM\Mapping\Id;
use App\Repository\MusicRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Container4oXqlel\getUserInterfaceService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

class HomeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/', name: 'app_home')]
    public function index(SerializerSerializerInterface $serializer): Response
    {
        $musics = $this->entityManager->getRepository(Music::class)->findAll();

        $json = $serializer->serialize($musics, 'json', ['groups' => 'music:read']);

        return $this->render('home/index.html.twig', [
            'jsonmusic' => $json,
            'music' => $musics

        ]);
    }


    // add favoris depuis la page d'acceuille 
    #[Route('add/favorite/{id}', name: 'add_favorite')]
    public function addFavorite(Request $request, Music $music, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $music->addFavori($user);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }


    // remove favoris depuis le page d'aceuille 
    #[Route('remove/favorite/{id}', name: 'remove_favorite')]
    public function removeFavori(Request $request, Music $music, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $music->removeFavori($user);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }


    // remove favoris depuis la partie favoris
    #[Route('remove/favorite/user/{id}', name: 'remove_favorite_User')]
    public function removeFavoriUser(Request $request, Music $music, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $music->removeFavori($user);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('favorites_index');
    }
}