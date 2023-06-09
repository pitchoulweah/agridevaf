<?php

namespace App\Services;

use App\Entity\Ventes\Commande;
use App\Entity\Ventes\DetailsCommande;
use App\Repository\Blog\OptionRepository;
use App\Repository\Ventes\CategorieProduitRepository;
use App\Repository\Ventes\ClientRepository;
use App\Repository\Ventes\CommandeRepository;
use App\Repository\Ventes\DetailsCommandeRepository;
use App\Repository\Ventes\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class ClientsService
{

    public function __construct(
        private ClientRepository $client,
        private CommandeRepository $commandeRepository,
        private DetailsCommandeRepository $detailsRepository,
        private OptionRepository $optionsService,
        private ManagerRegistry $registry,
        private LoggerInterface $logger
    ){
    }

    public function logonClient($valeur){
        return $this->client->findOneByTelOuEmail($valeur);
    }
    public function getlastCommande($currentClient){
        return $this->commandeRepository->getlastCommande($currentClient);
    }
    public function getTotalCommande($currentCommande){
        return $this->detailsRepository->getTotalCommande($currentCommande);
    }
    public function recherchePdtCommande($currentCommande, $pdt){
        return $this->detailsRepository->rechercheProduit($currentCommande, $pdt);
    }
    public function MiseaJourMontants(Commande $currentCommande){

        if($currentCommande){
            $montant = $this->detailsRepository->getTotalCommande($currentCommande)[0]['ht'];
            $hasTVA = $this->optionsService->hasTVA()->getValue();
            $TVA_VALUE = $this->optionsService->findTVA()->getValue()  * 0.01;
            //dd($montant[0]['ht']);
            if($hasTVA){
                $currentCommande->setHasTva(true);
                $currentCommande->setTva($TVA_VALUE * $montant);
                $currentCommande->setTtc($montant * (1 + $TVA_VALUE));
            } else {
                $currentCommande->setHasTva(false);
                $currentCommande->setTva(0);
                $currentCommande->setTtc($montant);
            }
                $currentCommande->setHt($montant);
                $this->registry->getManager()->persist($currentCommande);
                $this->registry->getManager()->flush($currentCommande);

                $this->logger->log(LogLevel::INFO, 'TVA, HT et TTC appliqués à la commande '.$currentCommande->getRef() );
        }

        return $currentCommande;
    }
}