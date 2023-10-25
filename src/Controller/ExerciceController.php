<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExerciceController extends AbstractController
{
    #[Route('/exercice/add', name: 'add_exercice')]
    #[Route('/exercice/{id}/edit', name: 'edit_exercice')]
    public function add(ManagerRegistry $doctrine, Exercice $exercice = null, Request $request): Response{

        if(!$exercice){
            $exercice = new Exercice();
        }
        
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $exercice = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($exercice);
            $entityManager->flush();
            return $this->redirectToRoute('app_exercice');
        }
    
        // vue pour afficher formulaire d'ajout
        return $this->render('exercice/add.html.twig', [
            'formAddexercice' => $form->createView(),
            'edit'=> $exercice->getId()
        ]);    
    } 

    #[Route('/exercice/{id}', name: 'show_exercice')]
    public function show(Exercice $exercice, ExerciceRepository $exerciceRepository): Response{

        $exerciceById = $exerciceRepository->find($exercice->getId());

        return $this->render('exercice/show.html.twig', [
            'exercice' => $exerciceById
        ]);    
    }   

    #[Route('/exercice', name: 'app_exercice')]
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        $exercices = $exerciceRepository->findAll();
        return $this->render('exercice/index.html.twig', [
            "exercices" => $exercices
        ]);
    }
}
