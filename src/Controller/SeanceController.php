<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Topic;
use App\Entity\Seance;
use App\Repository\SeanceRepository;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SeanceController extends AbstractController
{
    #[Route('/seance/remove_seanceFavoris/{seance_id}', name: 'remove_seanceFavoris')]
    #[ParamConverter('seance', options: ['id' => 'seance_id'])]
    public function removeFavSeance(ManagerRegistry $doctrine, Seance $seance): Response{

        $user = $this->getUser()->removeSeanceFavori($seance);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_seance');    
    }

    #[Route('/seance/add_seanceFavoris/{seance_id}', name: 'add_seanceFavoris')]
    #[ParamConverter('seance', options: ['id' => 'seance_id'])]
    public function addFavSeance(ManagerRegistry $doctrine, Seance $seance): Response{

        $user = $this->getUser()->addSeanceFavori($seance);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_seance');    
    }

    #[Route('/seance/delete/{id}', name: 'delete_seance')]
    #[ParamConverter('seance', options: ['id' => 'id'])]
    public function delete(Seance $seance,ManagerRegistry $doctrine): Response{

        $entityManager = $doctrine->getManager();
        $entityManager->remove($seance);
        $entityManager->flush();

        return $this->redirectToRoute('app_seance');    
    }

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
            "seances" => $seances,
            "User"=>$this->getUser()
        ]);
    }
}
