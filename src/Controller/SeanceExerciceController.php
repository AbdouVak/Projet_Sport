<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\SeanceExercice;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\SeanceExerciceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class SeanceExerciceController extends AbstractController
{
    #[Route('/seance/exercice/delete/{id}', name: 'delete_SeanceExercice')]
    #[ParamConverter('seanceExercice', options: ['id' => 'id'])]
    public function deleteSeanceExercice(SeanceExercice $seanceExercice,ManagerRegistry $doctrine): Response{

        $entityManager = $doctrine->getManager();
        $entityManager->remove($seanceExercice);
        $entityManager->flush();

        return $this->redirectToRoute('app_seance');      
    }

    #[Route('/seance/exercice/add/{seance_id}', name: 'add_exerciceToSeance')]
    #[Route('/seance/exercice/edit/{seance_id}', name: 'edit_exerciceToSeance')]
    #[ParamConverter('seance', options: ['id' => 'seance_id'])]
    public function addSeanceExercice(Seance $seance,ExerciceRepository $exerciceRepository,SeanceExerciceRepository $seanceExerciceRepository,ManagerRegistry $doctrine): Response{

        $exercice = $exerciceRepository->find($_POST['exercices']);
        
        $seanceExercice= $seanceExerciceRepository->findOneBy(['seance' => $seance->getId(), 'exercice' => $exercice->getId()]);
        if ($seanceExercice) {
            // Le SeanceExercice existe, mettez à jour ses propriétés
            $seanceExercice->setSerie($_POST['serie']);
            $seanceExercice->setRepetition($_POST['repetition']);
            $seanceExercice->setPoid($_POST['poid']);
        }else {
            // Le SeanceExercice n'existe pas, créez un nouveau
            $seanceExercice = new SeanceExercice();
            $seanceExercice->setExercice($exercice);
            $seanceExercice->setSeance($seance);
            $seanceExercice->setSerie($_POST['serie']);
            $seanceExercice->setRepetition($_POST['repetition']);
            $seanceExercice->setPoid($_POST['poid']);
        }
    
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
