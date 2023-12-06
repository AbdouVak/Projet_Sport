<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\ProfilType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    
    
    #[Route('/profil/edit', name: 'profil_edit')]
    public function editProfile(EntityManagerInterface $entityManager)
    {
        
    }
    
    #[Route('/profil/anonymize', name: 'profil_anonymize')]
    public function anonymize(EntityManagerInterface $entityManager)
    {
        // Récupérez tous les topics associés à l'utilisateur
        $topics = $this->getUser()->getTopics();

        // Dissociez les topics de l'utilisateur
        foreach ($topics as $topic) {
            // Assurez-vous que la relation est correctement gérée dans votre entité User
            $this->getUser()->removeTopic($topic);
            // Vous pouvez également définir un autre utilisateur comme propriétaire du topic ou effectuer d'autres actions nécessaires
        }

        // Supprimez l'utilisateur maintenant qu'il n'est plus lié à aucun topic
        $entityManager->remove($this->getUser());
        $entityManager->flush();

        // Redirection ou message de confirmation
        return $this->redirectToRoute('app_forum');
    }


    #[Route('/profil', name: 'app_profil')]
    public function index(Request $request,ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        $form = $this->createForm(ProfilType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            // Vérifier le mot de passe actuel
            $currentPassword = $form->get('currentPassword')->getData();
            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('danger', 'Mot de passe actuel incorrect.');
                return $this->redirectToRoute('profil_edit');
            }

            // Mettre à jour le pseudo
            $user->setPseudo($form->get('pseudo')->getData());

            // Mettre à jour l'email s'il est fourni
            $user->setEmail($form->get('email')->getData());


            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('app_profil');
        }

        // ...

        return $this->render('profil/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
