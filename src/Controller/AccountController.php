<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    #[Route('/mon-compte', name: 'app_account')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        // dd($user);
        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }
}