<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\SeanceExercice;
use App\Form\SeanceExerciceType;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class SeanceExerciceController extends AbstractController
{
    #[Route('/seance/exercice/add/{seance_id}', name: 'add_exericeToSeance')]
    #[ParamConverter('seance', options: ['id' => 'seance_id'])]
    public function addSeanceExercice(Seance $seance,ExerciceRepository $exerciceRepository,ManagerRegistry $doctrine): Response{

        $exercice = $exerciceRepository->find($_POST['exercices']);

        $seanceExercice = new SeanceExercice();
        $seanceExercice->setExercice($exercice);
        $seanceExercice->setSeance($seance);
        $seanceExercice->setSerie($_POST['serie']);
        $seanceExercice->setRepetition($_POST['repetition']);
        $seanceExercice->setPoid($_POST['poid']);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($seanceExercice);
        $entityManager->flush();
        
        return $this->redirectToRoute('show_seance',['id'=>$seance->getId()]);      
    }


    #[Route('/seance/exercice', name: 'app_seance_exercice')]
    public function index(): Response
    {
        return $this->render('seance_exercice/index.html.twig', [
            'controller_name' => 'SeanceExerciceController',
        ]);
    }
}
