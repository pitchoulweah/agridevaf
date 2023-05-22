<?php

namespace App\Controller\Admin\Ventes;

use App\Entity\Ventes\DetailsGrille;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DetailsGrilleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DetailsGrille::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Détails de la grille tarifaire');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->set(Crud::PAGE_EDIT, Action::INDEX);
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField:: new('produit', 'Produit')->setRequired(true);
        yield NumberField:: new('prix', 'Prix (F CFA)')->setRequired(true);
        yield AssociationField:: new('grille','Grille Tarifaire')->setRequired(true);
    }
}
