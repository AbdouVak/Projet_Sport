<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\CategorieMuscle;
use App\Form\SeanceByMuscleType;
use App\Repository\SeanceRepository;
use App\Repository\ExerciceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class FindSeanceController extends AbstractController
{
    #[Route('/find/seance', name: 'app_find_seance')]
    public function index(CategorieMuscle $categorieMuscle=null, SeanceRepository $seanceRepository,Request $request,ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $formChooseMuscle = $this->createForm(SeanceByMuscleType::class);
        $formChooseMuscle->handleRequest($request);

        if ($formChooseMuscle->isSubmitted() && $formChooseMuscle->isValid()) {
            $selectedMuscleId = $formChooseMuscle->getData()['categorieMuscle']->getId();

            $seances = $seanceRepository->findSeancesByCategorieMuscle($selectedMuscleId);
            $seances = $seanceRepository->findAll();
            $seanceFavs = $seanceRepository->findMostFavorisSeance();
    
            $pagination = $paginator->paginate(
                $seances, /* les données à paginer */
                $request->query->getInt('page', 1), /* numéro de la page, par défaut 1 */
                8 /* nombre d'éléments par page */
            );
            return $this->render('find_seance/index.html.twig', [
                
                'seances' => $pagination,
                'seanceFavs' => $seanceFavs,
                'formChooseMuscle' => $formChooseMuscle->createView()
            ]);
        }
        
        $seances = $seanceRepository->findAll();
        $seanceFavs = $seanceRepository->findMostFavorisSeance();

        $pagination = $paginator->paginate(
            $seances, /* les données à paginer */
            $request->query->getInt('page', 1), /* numéro de la page, par défaut 1 */
            8 /* nombre d'éléments par page */
        );
        return $this->render('find_seance/index.html.twig', [
            'seances' => $pagination,
            'seanceFavs' => $seanceFavs,
            'formChooseMuscle' => $formChooseMuscle->createView()
        ]);
    }
}
