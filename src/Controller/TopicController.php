<?php

namespace App\Controller;

use DateTime;
use App\Entity\Topic;
use App\Entity\Post;
use App\Form\PostType;
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
use Knp\Component\Pager\PaginatorInterface;

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
    public function show(Topic $topic,PostRepository $postRepository,Request $request,TopicRepository $topicRepository,ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $posts = $postRepository->findByTopicId($topic->getId());


        $formAddPost = $this->createForm(PostType::class);
        $formAddPost->handleRequest($request);


        if ($formAddPost->isSubmitted() && $formAddPost->isValid()) {
            $post = new Post();
            $formData = $formAddPost->getData();
            $topic = $topicRepository->find($formData['topic']);

            $post->setUser($this->getUser());
            $post->setTopic($topic);
            $post->setContenue($formData['contenue']);
            $post->setDateCreation(new DateTime());

            // Enregistrez le post dans la base de données, vous devrez peut-être ajuster cela selon votre entité Post
            $entityManager = $doctrine->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            // Faites ce que vous devez faire avec l'ID du topic, par exemple, enregistrez le post
            // ...
            
            return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);
        }

        $pagination = $paginator->paginate(
            $posts, /* les données à paginer */
            $request->query->getInt('page', 1), /* numéro de la page, par défaut 1 */
            7 /* nombre d'éléments par page */
        );

        return $this->render('topic/show.html.twig', [
            'formAddPost' => $formAddPost->createView(),
            'topic' => $topic,
            'posts' => $pagination,
        ]);

    }

    
}