<?php

namespace App\Controller\Admin\Ventes;

use App\Entity\Ventes\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Produits AGRIDEVAF')
            ->setPageTitle('edit', "Modifier le produit");
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField:: new('libelle');
        yield SlugField:: new('slug')->setTargetFieldName('libelle');
        yield TextEditorField:: new('description');
        yield NumberField:: new('prix');
        yield ChoiceField:: new('conditionnement')
            ->setChoices([
            'Bidon'=>'BIDON',
            'Carton'=>'CARTON',
            'Boîte'=>'BOITE',
            'Pack'=>'PACK'
        ]);
        yield ChoiceField:: new('unite')
            ->setChoices([
            'Kg'=>'KG',
            'hectare'=>'ha',
            'Litre(s)'=>'LITRES',
            'Unitaire'=>'UNITAIRE'
        ]);
        yield AssociationField:: new('categorie');
        yield BooleanField:: new('actif','Ce produit est-il actif ?');
        yield BooleanField:: new('vitrine','Ce produit apparait-il en première page ?');


        $mediaDir = $this->getParameter('medias_directory');
        $uploadDir = $this->getParameter('uploads_directory');


        $imageField = ImageField::new('image_produit', 'Photo')
            ->setBasePath($uploadDir)
            ->setUploadDir($mediaDir)
            ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');
        if(Crud::PAGE_EDIT == $pageName){
            $imageField->setRequired(false);
        }
        yield $imageField;
    }
}
