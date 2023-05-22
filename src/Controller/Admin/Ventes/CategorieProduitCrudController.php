<?php

namespace App\Controller\Admin\Ventes;

use App\Entity\Ventes\CategorieProduit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorieProduit::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Catégories Produits');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField:: new('libelle');
        yield SlugField:: new('slug')->setTargetFieldName('libelle');
        yield TextEditorField:: new('description');

        $mediaDir = $this->getParameter('medias_directory');
        $uploadDir = $this->getParameter('uploads_directory');


        $imageField = ImageField::new('image_categorie', 'Photo Catégorie')
            ->setBasePath($uploadDir)
            ->setUploadDir($mediaDir)
            ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');
        if(Crud::PAGE_EDIT == $pageName){
            $imageField->setRequired(false);
        }
        yield $imageField;
    }
}
