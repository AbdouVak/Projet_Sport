<?php

namespace App\Controller;

use App\Entity\Seance;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    #[Route('/user/toggleSeanceFavoris/{id}/{route}/{action}', name: 'toggleSeanceFavoris')]
    #[ParamConverter('seance', options: ['id' => 'seanceId'])]
    public function toggleFavorites(Seance $seance, ManagerRegistry $doctrine, string $route, string $action): Response
    {
        // Reste du code pour ajouter ou supprimer des favoris en fonction de $action...
        if ($action === 'add') {
            $this->getUser()->addSeanceFavori($seance);
        } elseif ($action === 'remove') {
            $this->getUser()->removeSeanceFavori($seance);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($this->getUser());
        $entityManager->flush();

        // Redirection vers l'URL d'origine
        return $this->redirectToRoute($route);
    }

    

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
