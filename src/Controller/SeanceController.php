<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\UserRepository;
use App\Repository\SeanceRepository;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeanceController extends AbstractController
{
    #[Route('/seance/add', name: 'add_seance')]
    public function add(ManagerRegistry $doctrine): Response{
        $seance = new Seance();
        $seance->setNom($_POST['nom']);
        $seance->setUser($this->getUser());

        $entityManager = $doctrine->getManager();
        $entityManager->persist($seance);
        $entityManager->flush();

        return $this->redirectToRoute('app_seance');    
    }

    #[Route('/seance/showAdd/', name: 'show_add_seance')]
    public function showAdd(): Response{

        return $this->render('seance/add.html.twig');    
    }

    #[Route('/seance/{id}', name: 'show_seance')]
    public function show(seance $seance, SeanceRepository $seanceRepository,ExerciceRepository $exerciceRepository): Response{

        $seanceById = $seanceRepository->find($seance->getId());
        
        $exercices = $exerciceRepository->findAll();

        return $this->render('seance/show.html.twig', [
            'seance' => $seanceById,
            'exercices' => $exercices
        ]);    
    }

    #[Route('/seance', name: 'app_seance')]
    public function index(SeanceRepository $seanceRepository): Response
    {
        $seances = $seanceRepository->seanceUtilisateur( $this->getUser()->getId());
        return $this->render('seance/index.html.twig', [
            "seances" => $seances
        ]);
    }
}
