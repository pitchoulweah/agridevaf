<?php

namespace App\Controller;

use App\Entity\MessageClient;
use App\Form\ContactsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    #[Route('/contacts', name: 'app_contacts')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $createdAt = new \DateTime();
        $message = new MessageClient();

        $form = $this->createForm(ContactsType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $manager = $doctrine->getManager();
            $message->setCreatedAt($createdAt);
            $manager->persist($message);
            $message= "Votre message a été envoyé avec succès";

            $manager->flush();
            $this->addFlash('success',  $message);
            return $this->redirectToRoute("app_portail");
        } else {
            return $this->render('contacts/index.html.twig',[
                'form' =>$form->createView()
            ]);
        }
    }
}
