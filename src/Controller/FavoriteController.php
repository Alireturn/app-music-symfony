<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Music;
use App\Entity\Favorite;
use App\Repository\MusicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Container4oXqlel\getUserInterfaceService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    // affichage des favoris 

    /**
     * @Route("/favorites", name="favorites_index")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
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

        return $this->render('favorite/index.html.twig', [
            'favoris' => $favorites,
        ]);
    }
}