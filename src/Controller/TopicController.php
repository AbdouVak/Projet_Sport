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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TopicController extends AbstractController
{

    #[Route('/topic/verrouille/{id}', name: 'veroullier_topic')]
    #[ParamConverter('topic', options: ['id' => 'id'])]
    public function VerrouillerTopic(ManagerRegistry $doctrine,Topic $topic = null): Response
    {
        $topic->setVerrouiller(true);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($topic);
        $entityManager->flush();
        return $this->redirectToRoute('app_topic');
    }

    #[Route('/topic/{id}', name: 'show_topic')]
    #[ParamConverter('topic', options: ['id' => 'id'])]
    public function show(Topic $topic,PostRepository $postRepository): Response
    {
        $posts = $postRepository->findByTopicId($topic->getId());
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'posts' => $posts,
            'seancesPartager'=> $this->getUser()->getSeances(),
            'seanceFavUsers'=> $this->getUser()->getSeanceFavoris()
        ]);
    }
}