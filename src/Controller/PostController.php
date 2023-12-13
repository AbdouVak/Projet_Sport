<?php

namespace App\Controller;

use DateTime;
use App\Entity\Post;
use App\Entity\Topic;
use App\Repository\SeanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PostController extends AbstractController
{
    #[Route('/post/add/{topic_id}', name: 'add_post')]
    #[ParamConverter('topic', options: ['id' => 'topic_id'])]
    public function add(ManagerRegistry $doctrine, Post $post = null, Topic $topic = null, SeanceRepository $seanceRepository): Response
    {
        

        $post = new post();
        $post->setUser($this->getUser());
        $post->setContenue($_POST['contenue']);
        $post->setDateCreation(new DateTime());
        $post->setTopic($topic);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirectToRoute('show_topic',['id'=>$topic->getId()]);      
    }

    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
