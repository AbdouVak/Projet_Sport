<?php

namespace App\Controller;

use DateTime;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Form\ForumType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\TopicRepository;
use App\Repository\CategorieTopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class ForumController extends AbstractController
{
    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }
    
    #[Route('/forum', name: 'app_forum')]
    public function index(Request $request,TopicRepository $topicRepository,CategorieTopicRepository $categorieTopicRepository,ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {   
        $topics = $topicRepository->findAll();

        /* Ajouter un topic */
        $formAddTopic = $this->createForm(TopicType::class);
        $formAddTopic->handleRequest($request);

        if ($formAddTopic->isSubmitted() && $formAddTopic->isValid()) {
            $token = $this->csrfTokenManager->getToken('topic')->getValue();
            
            // Validation du token CSRF
            if ($this->isCsrfTokenValid('topic', $token)) {
                $topic = new Topic();
                $topic = $formAddTopic->getData();
                $topic->setUser($this->getUser());
                $topic->setDateCreation(new DateTime());
                $topic->setVerrouiller(false);

                $entityManager = $doctrine->getManager();
                $entityManager->persist($topic);
                $entityManager->flush();
            }
            return $this->render('forum/index.html.twig', [
                'categorieTopics' => $categorieTopics,
                'formSearchTopic' => $formSearchTopic->createView(),
                'formAddTopic' => $formAddTopic->createView(),
                'topics' => $topics
            ]);
        }

        $topicPopular = $categorieTopicRepository->findMostPopularTopics();
        if (!empty($_POST['categorieTopic'])) {
            $topics = $topicRepository->findTopicsByCategory($_POST['categorieTopic']);
        } else {
            $topics = $topicRepository->findAll();
        }
    
        /* Affiche les topics par rapport à la recherche */
        $formSearchTopic = $this->createForm(ForumType::class);
        $formSearchTopic->handleRequest($request);
    
        if ($formSearchTopic->isSubmitted() && $formSearchTopic->isValid()) {
            $searchTerm = $formSearchTopic->get('search')->getData();
    
            $topics = $topicRepository->findTopicsBySearch($searchTerm);
        }
        $pagination = $paginator->paginate(
            $topics, /* les données à paginer */
            $request->query->getInt('page', 1), /* numéro de la page, par défaut 1 */
            8 /* nombre d'éléments par page */
        );

        return $this->render('forum/index.html.twig', [
            'formSearchTopic' => $formSearchTopic->createView(),
            'formAddTopic' => $formAddTopic->createView(),
            'topics' => $pagination, // Utilisez la pagination plutôt que la liste complète des topics
        ]);
    }

    
}
 