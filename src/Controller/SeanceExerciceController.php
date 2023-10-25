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
    #[Route('/seance/exercice/add/{seance_id}', name: 'add_seance_exercice')]
    #[Route('/seance/exercice/{id}/edit', name: 'edit_seance_exercice')]
    public function addSeanceExercice(ManagerRegistry $doctrine, SeanceExercice $seanceExercice = null,Request $request): Response{
        if(!$seanceExercice){
            $seanceExercice = new SeanceExercice();
        }
        $form = $this->createForm(SeanceExerciceType::class, $seanceExercice);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $seanceExercice = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($seanceExercice);
            $entityManager->flush();
            return $this->redirectToRoute('app_seance');
        }
    
        // vue pour afficher formulaire d'ajout
        return $this->render('seance_exercice/add.html.twig', [
            'formAddseanceExercice' => $form->createView(),
            'edit'=> $seanceExercice->getId(),
        ]);    
    }

    #[Route('/seance/exercice', name: 'app_seance_exercice')]
    public function index(): Response
    {
        return $this->render('seance_exercice/index.html.twig', [
            'controller_name' => 'SeanceExerciceController',
        ]);
    }
}
