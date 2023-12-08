<?php

namespace App\Controller;

use App\Form\SeanceByMuscleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Seance;
use App\Repository\SeanceRepository;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class FindSeanceController extends AbstractController
{
    #[Route('/find/seance', name: 'app_find_seance')]
    public function index(SeanceRepository $seanceRepository,Request $request,ManagerRegistry $doctrine): Response
    {

        $formChooseMuscle = $this->createForm(SeanceByMuscleType::class);
        $formChooseMuscle->handleRequest($request);

        $seances = $seanceRepository->findAll();
        return $this->render('find_seance/index.html.twig', [
            'seances' => $seances,
            'formChooseMuscle' => $formChooseMuscle->createView()
        ]);
    }
}
