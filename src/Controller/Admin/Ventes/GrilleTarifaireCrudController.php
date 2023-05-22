<?php

namespace App\Controller\Admin\Ventes;

use App\Entity\Ventes\GrilleTarifaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GrilleTarifaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GrilleTarifaire::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Grilles Tarifaires');
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField:: new('libelle');
        yield BooleanField::new('actif');
        /*yield AssociationField::new('detailsGrilles');*/
    }
}
