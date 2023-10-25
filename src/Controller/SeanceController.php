<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeanceController extends AbstractController
{
    #[Route('/seance/add', name: 'add_seance')]
    #[Route('/seance/{id}/edit', name: 'edit_seance')]
    public function add(ManagerRegistry $doctrine, Seance $seance = null,Request $request): Response{

        if(!$seance){
            $seance = new Seance();
        }

        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $seance = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($seance);
            $entityManager->flush();
            return $this->redirectToRoute('add_seance_seance',['seance_id'=>$seance->getId()]
            );
        }
    
        // vue pour afficher formulaire d'ajout
        return $this->render('seance/add.html.twig', [
            'formAddseance' => $form->createView(),
            'edit'=> $seance->getId(),
        ]);    
    }

    #[Route('/seance/{id}', name: 'show_seance')]
    public function show(seance $seance, SeanceRepository $seanceRepository): Response{

        $seanceById = $seanceRepository->find($seance->getId());

        return $this->render('seance/show.html.twig', [
            'seance' => $seanceById
        ]);    
    }

    #[Route('/seance', name: 'app_seance')]
    public function index(SeanceRepository $seanceRepository): Response
    {
        $seances = $seanceRepository->findAll();
        return $this->render('seance/index.html.twig', [
            "seances" => $seances
        ]);
    }
}
