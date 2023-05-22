<?php

namespace App\Services;

use App\Repository\Blog\OptionRepository;
use App\Repository\Ventes\CategorieProduitRepository;
use App\Repository\Ventes\ProduitRepository;

class CatalogueServices
{
    public function __construct(
        private CategorieProduitRepository $categories_produits,
        private ProduitRepository $produits
    )
    {

    }

    public function findAllCategorie(){
        /*dd($this->categories_produits->countCaategories());*/
      return  $this->categories_produits;
    }

    public function findAllProduits(){
        return  $this->produits;
    }

    /*public function findPdtByCategorie(string $codeproduit, $idproduit)
    {
        return $this->produits->findPdtByCategorie($codeproduit, $idproduit);
    }*/
}