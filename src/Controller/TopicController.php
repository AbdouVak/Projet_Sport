<?php

namespace App\Controller;

use DateTime;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieTopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    #[Route('/topic/add', name: 'add_topic')]
    public function add(ManagerRegistry $doctrine, Topic $topic = null, Request $request,CategorieTopicRepository $categorieTopicRepository ): Response
    {
        $categorieTopic =  $categorieTopicRepository->find($_POST['categorieTopic']);

        if(!$topic){

            $topic = new Topic();

            $topic->setUser($this->getUser());
            $topic->setTitre($_POST['titre']);
            $topic->setContenue($_POST['contenue']);
            $topic->setDateCreation(new DateTime());
            $topic->setVerrouiller(false);
            $topic->setCategorieTopic($categorieTopic);
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_topic');
    }

    #[Route('/topic/{id}', name: 'show_topic')]
    #[ParamConverter('topic', options: ['id' => 'id'])]
    public function show(Topic $topic,PostRepository $postRepository): Response
    {
        $posts = $postRepository->findByTopicId($topic->getId());
        
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'posts' => $posts
        ]);
    }

    #[Route('/topic', name: 'app_topic')]
    public function index(CategorieTopicRepository $categorieTopicRepository,TopicRepository $topicRepository): Response
    {
        $categorieTopics = $categorieTopicRepository->findAll();
        $topics = $topicRepository->findAll();
        return $this->render('topic/index.html.twig', [
            'categorieTopics' => $categorieTopics,
            'topics' => $topics
        ]);
    }
}