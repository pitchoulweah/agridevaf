<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthentficationController extends AbstractController
{
    #[Route('/authentfication', name: 'app_authentfication')]
    public function index(Request $request): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        return $this->render('ventes/client/authentification.html.twig',[
            'hostname'=>$hostname
        ]);
    }
}
