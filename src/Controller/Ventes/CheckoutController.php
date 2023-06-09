<?php

namespace App\Controller\Ventes;

use App\Entity\Pays;
use App\Entity\Ventes\DetailsCommande;
use App\Entity\Ville;
use App\Form\Ventes\ClientType;
use App\Repository\Ventes\DetailsCommandeRepository;
use App\Services\ClientsService;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Payum\Core\Model\Payment;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\Capture;
use Payum\Core\Request\GetHumanStatus;
class CheckoutController extends AbstractController
{
    private $client;
    public function __construct(
        ClientsService $client,
        private ManagerRegistry $manager
    )
    {
        $this->client = $client;
    }
    #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request, DetailsCommandeRepository $prdts): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        $currentClient = $request->getSession()->get('CURRENT_CLIENT_SESSION');
        //dd($currentClient);
        if (!$currentClient){
            return $this->redirectToRoute('app_authentfication');
        }

        //$clt = $this->client->logonClient($currentClient);

        //dd($clt);
        $currentCommande =   $this->client->getlastCommande($currentClient);

        $details =   $prdts->findByCommande($currentCommande);
        $totalCommande = $this->client->getTotalCommande($currentCommande);

        $form = $this->createForm(ClientType::class, $currentClient);
        $form->remove('nom');
        $form->remove('prenoms');
        $form->remove('telephone');
        $form->remove('email');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $majClient = $this->manager->getManager();

            $message= "Vos données ont été ùises à jour avec succès";
            $majClient->persist($currentClient);
            $majClient->flush($currentClient);
            $this->addFlash('success',  $message);

        }

        $payment = new Payment;
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount(123); // 1.23 EUR
        $payment->setDescription('A description');
        $payment->setClientId('anId');
        $payment->setClientEmail('foo@example.com');

        $gateway = $this->get('payum')->getGateway('offline');
        $gateway->execute(new Capture($payment));

        return $this->render('ventes/checkout/index.html.twig',[
            'client'=>$currentClient,
            'current_commande'=>$currentCommande,
            'form'=>$form,
            'details_commande'=>$details,
            'hostname'=>$hostname,
            'villes'=>$this->manager->getRepository(Ville::class)->findAll(),
            'pays'=>$this->manager->getRepository(Pays::class)->findAll()
        ]);
    }

    #[Route('/checkout/{etre_livre}', name: 'maj_commande_expedition')]
    public function maj_commande_expedition(
        Request $request,
                bool $etre_livre
    ): Response
    {

        $currentClient = $request->getSession()->get('CURRENT_CLIENT_SESSION');
        //dd($currentClient);
        if (!$currentClient){
            return $this->redirectToRoute('app_authentfication');
        }

        $currentCommande =   $this->client->getlastCommande($currentClient);
        $currentCommande->setEtreLivre($etre_livre);
        //dd($etre_livre);
        $this->manager->getManager()->persist($currentCommande);
        $this->manager->getManager()->flush($currentCommande);

        return $this->redirectToRoute('app_checkout');
    }
}