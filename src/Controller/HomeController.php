<?php

namespace App\Controller;

use App\Repository\SeanceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SeanceRepository $seanceRepository): Response
    {
        $seances = $seanceRepository->findMostFavorisSeance();

        return $this->render('home/index.html.twig', [
            "seances" => $seances
        ]);
    }
}
