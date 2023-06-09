<?php

namespace App\Controller\Ventes;

use App\Entity\Ventes\Client;
use App\Form\Ventes\InscriptionType;
use App\Repository\Ventes\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    private $client;
    private $nouveau;
    public function __construct(ClientRepository $client)
    {
        $this->client = $client;
        $this->nouveau = true;
    }


    #[Route('/mon-compte', name: 'app_client')]
    public function addAccount(ManagerRegistry $doctrine, Request $request): Response
    {
        $client = new Client();

        $form = $this->createForm(InscriptionType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && ($this->nouveau)){
            $manager = $doctrine->getManager();
            $manager->persist($client);
            $message= "Votre enregistrement vient d'être pris en compte";

            $manager->flush();
            $request->getSession()->set('CURRENT_CLIENT_SESSION', $client);
            $this->addFlash('success',  $message);
            return $this->redirectToRoute("app_portail");
        } else {
            return $this->render('ventes/client/index.html.twig',[
                'form' =>$form->createView()
            ]);
        }

    }
    #[Route('/authentification/{valeur}', name: 'authentification_client')]
    public function rechercheClient(Request $request, $valeur){
        $authClient = $this->client->findOneByTel($valeur);
        $this->nouveau = false;
        if ($authClient){
           /* $json = 'CLIENT_NOT_FOUND';
            return new Response($json);
        } else {*/
          /*  $json = json_encode([
                'nom'=>$authClient->getNom(),
                'prenoms'=>$authClient->getPrenoms(),
                'telephone'=>$authClient->getTelephone(),
                'email'=>$authClient->getEmail()
            ]);*/
            $request->getSession()->set('CURRENT_CLIENT_SESSION', $authClient);
            //dd($valeur);

            //return new Response($json);
            return $this->redirectToRoute('boutique');
        }

    }

}
