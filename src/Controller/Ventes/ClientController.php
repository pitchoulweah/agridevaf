<?php

namespace App\Controller\Ventes;

use App\Entity\Ventes\Client;
use App\Form\Ventes\ClientType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    #[Route('/mon-compte', name: 'app_client')]
    public function addAccount(ManagerRegistry $doctrine, Request $request): Response
    {


        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager = $doctrine->getManager();
            $manager->persist($client);
            $message= "Votre enregistrement vient d'être pris en compte";

            $manager->flush();
            $request->getSession()->set('CURRENT_CLIENT_SESSION', $client->getTelephone());
            $this->addFlash('success',  $message);
            return $this->redirectToRoute("app_portail");
        } else {
            return $this->render('ventes/client/index.html.twig',[
                'form' =>$form->createView()
            ]);
        }

    }
}
