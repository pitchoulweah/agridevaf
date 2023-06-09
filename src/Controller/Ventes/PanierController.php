<?php

namespace App\Controller\Ventes;

use App\Entity\Ventes\Client;
use App\Entity\Ventes\Commande;
use App\Entity\Ventes\DetailsCommande;
use App\Repository\Blog\OptionRepository;
use App\Repository\Ventes\ClientRepository;
use App\Repository\Ventes\ProduitRepository;
use App\Services\ClientsService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $client;
    public function __construct(
        ClientsService $client,
        private ManagerRegistry $manager
    )
    {
        $this->client = $client;
    }

    #[Route('/mon-panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        $currentClient = $request->getSession()->get('CURRENT_CLIENT_SESSION');
        //dd($currentClient);


        if (!$currentClient){
            return $this->redirectToRoute('app_authentfication');
        }

        $currentCommande =   $this->client->getlastCommande($currentClient);

        $details =   $this->manager->getRepository(DetailsCommande::class)->findByCommande($currentCommande);


        return $this->render('panier/index.html.twig',[
            'details_commande'=>$details,
            'current_commande'=>$currentCommande
        ]);
    }

    #[Route('/mon panier/{id_produit}', name: 'process_commande')]
    public function process(
        Request $request,
        ClientRepository $clientRepository,
        OptionRepository $optionRepository,
        ProduitRepository $produitRepository,
        $id_produit
        ): Response
    {
        $currentClient = $request->getSession()->get('CURRENT_CLIENT_SESSION');
        //dd($currentClient);
        if (!$currentClient){
            return $this->redirectToRoute('app_authentfication');
        }
        $currentCommande =   $this->client->getlastCommande($currentClient);

        $tva = $optionRepository->hasTVA()->getValue();
        $tva_value = 0;

        if (!$currentCommande){
            $currentCommande = new Commande();
            $dateCommande = new \DateTime();
            //$dateCommande = $dateCommande->format('Y-m-d');
            $currentCommande->setClient($currentClient);
            $currentCommande->setCloture(false);
            $currentCommande->setDateCommande($dateCommande);
            $currentCommande->setEnvoye(false);
            $currentCommande->setValide(false);
            $currentCommande->setRef(uniqid());
            $currentCommande->setEtreLivre(false);
            $currentCommande->setLivre(false);
            if($tva == 1){
                $currentCommande->setHasTva(true);
                $tva_value = 0.01 * $optionRepository->findTVA()->getValue();
            } else {
                $currentCommande->setHasTva(false);
            }

            //dd($currentCommande);
            $this->manager->getManager()->persist($currentCommande);
           //dd($currentCommande);
            $this->manager->getManager()->flush($currentCommande);

        }
        //$this->manager->getManager()->refresh($currentCommande);
        if($currentCommande->getHasTva()){
            $tva_value = 0.01 * $optionRepository->findTVA()->getValue();
        }

        $newProduit = $produitRepository->find($id_produit);
        //Recherche si le produit a déja été commandé
        $Produit = $this->client->recherchePdtCommande($currentCommande,$newProduit);

        //dd($ProduitDetail);


        if($Produit){
            //SI déja commandé
            $ProduitDetail = $this->client->recherchePdtCommande($currentCommande,$newProduit)[0];
            $ProduitDetail->setQte($ProduitDetail->getQte()+1);
            $ProduitDetail->setTotalht(($ProduitDetail->getQte())*$ProduitDetail->getPu());
            $ProduitDetail->setTotalttc(($ProduitDetail->getQte())*$ProduitDetail->getPu()*(1 +  $tva_value));
        } else {
            //SINON
            $ProduitDetail = new DetailsCommande();
            $ProduitDetail->setProduit($newProduit);
            $ProduitDetail->setCommande($currentCommande);
            $ProduitDetail->setPu($newProduit->getPrix());
            $ProduitDetail->setQte(1);
            $ProduitDetail->setTotalht($newProduit->getPrix());
            $ProduitDetail->setTotalttc($newProduit->getPrix()*(1 +  $tva_value));
        }

        $this->manager->getManager()->persist($ProduitDetail);
        $this->manager->getManager()->flush($ProduitDetail);

        $this->client->MiseaJourMontants($currentCommande);
        return $this->redirectToRoute('app_panier');
    }
    #[Route('/mon panier/remove/{id_detail}', name: 'process_commande_remove')]
    public function removeProduct(
        Request $request,
        $id_detail
    ): Response
    {
        $currentClient = $request->getSession()->get('CURRENT_CLIENT_SESSION');
        //dd($currentClient);
        if (!$currentClient){
            return $this->redirectToRoute('app_authentfication');
        }
        $currentDetail =   $this->manager->getRepository(DetailsCommande::class)->find($id_detail);

        $this->manager->getManager()->remove($currentDetail);
        $this->manager->getManager()->flush($currentDetail);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/mon panier/{id_produit}/{nb_produits}', name: 'process_commande_nb')]
    public function enregistrerProduits(
        Request $request,
        ClientRepository $clientRepository,
        OptionRepository $optionRepository,
        ProduitRepository $produitRepository,
        $id_produit,
        $nb_produits
    ): Response
    {
        $currentClient = $request->getSession()->get('CURRENT_CLIENT_SESSION');
        //dd($currentClient);
        if (!$currentClient){
            return $this->redirectToRoute('app_authentfication');
        }
        $currentCommande =   $this->client->getlastCommande($currentClient);

        $tva = $optionRepository->hasTVA()->getValue();
        $tva_value = 0;

        if (!$currentCommande){
            $currentCommande = new Commande();
            $dateCommande = new \DateTime();
            //$dateCommande = $dateCommande->format('Y-m-d');
            $currentCommande->setClient($currentClient);
            $currentCommande->setCloture(false);
            $currentCommande->setDateCommande($dateCommande);
            $currentCommande->setEnvoye(false);
            $currentCommande->setValide(false);
            $currentCommande->setRef(uniqid());
            $currentCommande->setEtreLivre(false);
            $currentCommande->setLivre(false);
            if($tva == 1){
                $currentCommande->setHasTva(true);
                $tva_value = 0.01 * $optionRepository->findTVA()->getValue();
            } else {
                $currentCommande->setHasTva(false);
            }

            //dd($currentCommande);
            $this->manager->getManager()->persist($currentCommande);
            //dd($currentCommande);
            $this->manager->getManager()->flush($currentCommande);

        }
        //$this->manager->getManager()->refresh($currentCommande);
        if($currentCommande->getHasTva()){
            $tva_value = 0.01 * $optionRepository->findTVA()->getValue();
        }

        $newProduit = $produitRepository->find($id_produit);
        //Recherche si le produit a déja été commandé
        $Produit = $this->client->recherchePdtCommande($currentCommande,$newProduit);

        //dd($ProduitDetail);


        if($Produit){
            //SI déja commandé
            $ProduitDetail = $this->client->recherchePdtCommande($currentCommande,$newProduit)[0];
            $ProduitDetail->setQte($ProduitDetail->getQte()+$nb_produits);
            $ProduitDetail->setTotalht(($ProduitDetail->getQte()+$nb_produits)*$ProduitDetail->getPu());
            $ProduitDetail->setTotalttc(($ProduitDetail->getQte()+$nb_produits)*$ProduitDetail->getPu()*(1 +  $tva_value));
        } else {
            //SINON
            $ProduitDetail = new DetailsCommande();
            $ProduitDetail->setProduit($newProduit);
            $ProduitDetail->setCommande($currentCommande);
            $ProduitDetail->setPu($newProduit->getPrix());
            $ProduitDetail->setQte(1);
            $ProduitDetail->setTotalht($newProduit->getPrix());
            $ProduitDetail->setTotalttc($newProduit->getPrix()*(1 +  $tva_value));
        }

        $this->manager->getManager()->persist($ProduitDetail);
        $this->manager->getManager()->flush($ProduitDetail);

        $this->client->MiseaJourMontants($currentCommande);
        return $this->redirectToRoute('app_panier');
    }
}
