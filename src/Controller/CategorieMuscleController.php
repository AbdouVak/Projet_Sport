<?php

namespace App\Controller;

use App\Entity\CategorieMuscle;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieMuscleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CategorieMuscleType;

class CategorieMuscleController extends AbstractController
{
    #[Route('/categorie/muscle/add', name: 'add_categorie_muscle')]
    #[Route('/categorie/muscle/{id}/edit', name: 'edit_categorie_muscle')]
    public function add(ManagerRegistry $doctrine, CategorieMuscle $categorieMuscle = null, Request $request): Response{

        if(!$categorieMuscle){
            $categorieMuscle = new CategorieMuscle();
        }
        $form = $this->createForm(CategorieMuscleType::class, $categorieMuscle);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $categorieMuscle = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($categorieMuscle);
            $entityManager->flush();
            return $this->redirectToRoute('app_categorie_muscle');
        }
    
        // vue pour afficher formulaire d'ajout
        return $this->render('categorie_muscle/add.html.twig', [
            'formAddcategorieMuscle' => $form->createView(),
            'edit'=> $categorieMuscle->getId()
        ]);    
    } 

    #[Route('/categorie/muscle', name: 'app_categorie_muscle')]
    public function index(CategorieMuscleRepository $categorieMuscleRepository): Response
    {
        $muscles = $categorieMuscleRepository->findAll();
        return $this->render('categorie_muscle/index.html.twig', [
            "muscles" => $muscles
        ]);
    }
}
