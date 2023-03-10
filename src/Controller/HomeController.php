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
use Symfony\Component\HttpFoundation\Cookie;

class HomeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/', name: 'app_home')]
    public function index(SerializerSerializerInterface $serializer, Request $request): Response
    {
        $musics = $this->entityManager->getRepository(Music::class)->findAll();

        $json = $serializer->serialize($musics, 'json', ['groups' => 'music:read']);


        $selectedMusic = $request->cookies->get('selected_music');





        return $this->render('home/index.html.twig', [
            'jsonmusic' => $json,
            'music' => $musics,
            'cookiemusic' => $selectedMusic

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

        return $this->redirectToRoute('app_account');
    }

    public function selectMusic(Request $request, $musicId)
    {
        // Récupère l'URL de la musique à partir de la base de données en utilisant l'ID de la musique
        $music = $this->getDoctrine()->getRepository(Music::class)->find($musicId);

        $music = $this->getDoctrine()->getRepository(Music::class)->find($musicId);
        $musicUrl = $music->getUrl();

        // $response = new Response();
        // $response->headers->setCookie(Cookie::create('selected_music', $musicUrl));
        // $response->send();

        $response = new Response();
        $response->headers->setCookie(
            new Cookie('selected_music', $musicId, time() + 3600, '/')
        );
        $response->send();

        // Vérifier si la musique existe
        // if (!$music) {
        //     throw $this->createNotFoundException('La musique sélectionnée n\'existe pas.');
        // }

        // // Passer les informations de la musique à votre lecteur audio
        // $musicUrl = $music->getUrl();
        // echo "<script>playSelectedMusic('" . $musicUrl . "');</script>";

        return $this->redirectToRoute('app_home');
        // Faites ce que vous devez faire pour lire la musique ici
    }
    #[Route('/select-music2/{musicId}', name: 'select-music2')]
    public function selectMusic2(Request $request, $musicId)
    {
        // Récupère l'URL de la musique à partir de la base de données en utilisant l'ID de la musique
        $music = $this->getDoctrine()->getRepository(Music::class)->find($musicId);

        $music = $this->getDoctrine()->getRepository(Music::class)->find($musicId);
        $musicUrl = $music->getUrl();

        // $response = new Response();
        // $response->headers->setCookie(Cookie::create('selected_music', $musicUrl));
        // $response->send();

        $response = new Response();
        $response->headers->setCookie(
            new Cookie('selected_music', $musicId, time() + 3600, '/')
        );
        $response->send();


        return $this->redirectToRoute('app_account');
        // Faites ce que vous devez faire pour lire la musique ici
    }
}