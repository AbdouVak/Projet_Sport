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

class ForumController extends AbstractController
{
    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }
    
    #[Route('/forum', name: 'app_forum')]
    public function index(Topic $topic = null,Request $request,TopicRepository $topicRepository,CategorieTopicRepository $categorieTopicRepository,ManagerRegistry $doctrine): Response
    {   
        if(!$topic){
            $topic = new Topic();
        }

        $topics = $topicRepository->findAll();

        /* Trie les topic par categorie */
        if (!empty($_POST['categorieTopic'])){
            $topics = $topicRepository->findTopicsByCategory($_POST['categorieTopic']);
        }else{
            $topics = $topicRepository->findAll();
        }
        $categorieTopics = $categorieTopicRepository->findAll();
        
        /* Affiche les topic par rapport au recherche */
        $formSearchTopic = $this->createForm(ForumType::class);
        $formSearchTopic->handleRequest($request);

        if ($formSearchTopic->isSubmitted() && $formSearchTopic->isValid()) {
            $searchTerm= $formSearchTopic->get('search')->getData();

            $topics = $topicRepository->findTopicsBySearch($searchTerm);
        }

        /* Ajouter un topic */
        $formAddTopic = $this->createForm(TopicType::class);
        $formAddTopic->handleRequest($request);

        if ($formAddTopic->isSubmitted() && $formAddTopic->isValid()) {
            $token = $this->csrfTokenManager->getToken('topic')->getValue();
            
            // Validation du token CSRF
            if ($this->isCsrfTokenValid('topic', $token)) {
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

        return $this->render('forum/index.html.twig', [
            'categorieTopics' => $categorieTopics,
            'formSearchTopic' => $formSearchTopic->createView(),
            'formAddTopic' => $formAddTopic->createView(),
            'topics' => $topics
        ]);
    }
}
