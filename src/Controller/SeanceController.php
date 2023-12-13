<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Topic;
use App\Entity\Seance;
use App\Form\SeanceType;
use App\Entity\SeanceExercice;
use App\Form\SeanceExerciceType;
use App\Repository\SeanceRepository; 
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\SeanceExerciceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SeanceController extends AbstractController
{
    private $csrfTokenManager;
    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    #[Route('/seance/delete/{id}', name: 'delete_seance')]
    #[ParamConverter('seance', options: ['id' => 'id'])]
    public function delete(Seance $seance,ManagerRegistry $doctrine): Response{

        $entityManager = $doctrine->getManager();
        $entityManager->remove($seance);
        $entityManager->flush();

        return $this->redirectToRoute('app_seance');    
    }

    #[Route('/seance/{id}', name: 'show_seance')]
    #[ParamConverter('seance', options: ['id' => 'id'])]
    public function show(Seance $seance, SeanceRepository $seanceRepository,ExerciceRepository $exerciceRepository,Request $request,ManagerRegistry $doctrine): Response{

        $seanceById = $seanceRepository->find($seance->getId());
        $arrayESs = [];
        foreach($seanceById->getSeanceExercices() as $seanceExecices){

            $formEditSeanceExercice = $this->createForm(SeanceExerciceType::class,$seanceExecices);
            $formEditSeanceExercice->handleRequest($request);
            $arrayESs[] =  $formEditSeanceExercice->createView();
        }

        $formAddSeanceExercice = $this->createForm(SeanceExerciceType::class);
        $formAddSeanceExercice->handleRequest($request);


        if ($formAddSeanceExercice->isSubmitted() && $formAddSeanceExercice->isValid()) {
            
            $formData = $formAddSeanceExercice->getData();

            $seanceExercice = new SeanceExercice();
            $seanceExercice->setSerie($formData['serie']);
            $seanceExercice->setRepetition($formData['repetition']);
            $seanceExercice->setPoid($formData['poid']);
            $seanceExercice->setExercice($formData['exercice']);
            $seanceExercice->setSeance($seance);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($seanceExercice);
            $entityManager->flush();
        }
        return $this->render('seance/show.html.twig', [
            
            'formAddSeanceExercice' => $formAddSeanceExercice->createView(),
            'seance' => $seanceById,
            'arrayESs' =>$arrayESs
        ]);    
    }

    #[Route('/seance', name: 'app_seance')]
    public function index(SeanceRepository $seanceRepository,Request $request,ManagerRegistry $doctrine): Response
    {

        $formAddSeance = $this->createForm(SeanceType::class);
        $formAddSeance->handleRequest($request);

        if ($formAddSeance->isSubmitted() && $formAddSeance->isValid()) {
            $token = $this->csrfTokenManager->getToken('seance')->getValue();
            
            if ($this->isCsrfTokenValid('seance', $token)) {
                $seance = new Seance();
                $formData = $formAddSeance->getData();
                $seance->setUser($this->getUser());
                $seance->setNom($formData['nom']);

                $seanceExercice = new SeanceExercice();
                $seanceExercice->setSerie($formData['serie']);
                $seanceExercice->setRepetition($formData['repetition']);
                $seanceExercice->setPoid($formData['poid']);
                $seanceExercice->setExercice($formData['exercice']);
                $seanceExercice->setSeance($seance);

                $entityManager = $doctrine->getManager();
                $entityManager->persist($seance);
                $entityManager->flush();

                $entityManager = $doctrine->getManager();
                $entityManager->persist($seanceExercice);
                $entityManager->flush();
            }
        }

        $seances = $seanceRepository->seanceUtilisateur( $this->getUser()->getId());
        $nbrSeance= count($seances);
        return $this->render('seance/index.html.twig', [
            "nbrSeance" =>$nbrSeance,
            "seances" => $seances,
            "User"=>$this->getUser(),
            'formAddSeance' => $formAddSeance->createView(),
        ]);
    }
}
