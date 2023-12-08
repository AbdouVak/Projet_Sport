<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Topic;
use App\Form\SeanceType;
use App\Entity\Seance;
use App\Repository\SeanceRepository;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

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

    #[Route('/seance/add', name: 'add_seance')]
    public function add(Seance $seance = null,ManagerRegistry $doctrine): Response{
        
        $seance = new Seance();
        $seance->setNom($_POST['nom']);
        $seance->setUser($this->getUser());

        $entityManager = $doctrine->getManager();
        $entityManager->persist($seance);
        $entityManager->flush();

        return $this->redirectToRoute('app_seance');    
        // Affichage du formulaire
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
    public function index(Seance $seance = null,SeanceRepository $seanceRepository,Request $request,ManagerRegistry $doctrine): Response
    {
        if(!$seance){
            $seance = new Seance();
        }

        $formAddSeance = $this->createForm(SeanceType::class,$seance);
        $formAddSeance->handleRequest($request);

        if ($formAddSeance->isSubmitted() && $formAddSeance->isValid()) {
            $token = $this->csrfTokenManager->getToken('seance')->getValue();
            
            if ($this->isCsrfTokenValid('seance', $token)) {
                $seance = $formAddSeance->getData();
                $seance->setUser($this->getUser());
                // Le formulaire est soumis et valide
                $entityManager = $doctrine->getManager();
                $entityManager->persist($seance);
                $entityManager->flush();
            }
        }
        $seances = $seanceRepository->seanceUtilisateur( $this->getUser()->getId());
        return $this->render('seance/index.html.twig', [
            "seances" => $seances,
            "User"=>$this->getUser(),
            'formAddSeance' => $formAddSeance->createView()
        ]);
    }
}
