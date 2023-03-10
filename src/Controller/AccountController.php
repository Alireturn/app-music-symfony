<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Music;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\serializer;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

class AccountController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    #[Route('/mon-compte', name: 'app_account')]
    public function index(Request $request, EntityManagerInterface $entityManager, SerializerSerializerInterface $serializer): Response
    {
        $selectedMusic = $request->cookies->get('selected_music');

        $user = $this->getUser();
        $userId = $user->getId();
        $doctrine = $this->getDoctrine();

        $queryBuilder = $this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('m')
            ->from(Music::class, 'm')
            ->join('m.favoris', 'f')
            ->where('f.id = :userId')
            ->setParameter('userId', $userId);

        $favorites = $queryBuilder->getQuery()->getResult();
        // dd($favorites);
        $json = $serializer->serialize($favorites, 'json', ['groups' => 'music:read']);


        return $this->render('account/index.html.twig', [
            'user' => $user,
            'favoris' => $favorites,
            'jsonmusic' => $json,
            'cookiemusic' => $selectedMusic
        ]);
    }
}