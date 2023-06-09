<?php

namespace App\Form\Ventes;

use App\Entity\Pays;
use App\Entity\Ventes\Client;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
               'label'=>false,
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'votre nom',
                    'class'=>'form-control p-4 mb-4 fs-4'
                ],
                'constraints'=>new NotBlank(['message'=>"Nous avons besoin de votre nom"]),
            ])
            ->add('prenoms', TextType::class, [
                'label'=>false,
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'votre prénoms',
                    'class'=>'form-control p-4 mb-4 fs-4'
                ],
                'constraints'=>new NotBlank(['message'=>"Votre prénoms est necessaire"]),
            ])
            ->add('telephone', TextType::class, [
                'label'=>false,
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'le numéro de téléphone',
                    'class'=>'form-control p-4 mb-4 fs-4'
                ],
                'constraints'=>new NotBlank(['message'=>"Renseignez SVP votre numéro de téléphone"]),
            ])
            ->add('email', TextType::class, [
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'votre email',
                    'class'=>'form-control p-4 mb-4 fs-4'
                ]
            ])
            ->add('adresse_facturation', TextType::class, [
                'label'=>false,
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Adresse (Rue,ville, commune etc.',
                    'class'=>'form-control p-4 mb-4 fs-4'
                ],
                'constraints'=>new NotBlank(['message'=>"l'adresse de facturation est obligatoire"]),
            ])
            ->add('ville_facturation', TextType::class, [
                'label'=>false,
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'ville',
                    'class'=>'form-control text-dark'
                ],
                'constraints'=>new NotBlank(['message'=>"la ville de facturation est obligatoire"]),
            ])
            ->add('pays_facturation', TextType::class, [
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'pays',
                    'class'=>'form-control text-dark'
                ]
            ])
            ->add('adresse_livraison', TextType::class, [
                'label'=>false,
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'rue, commune, ville etc.',
                    'class'=>'form-control p-4 mb-4 fs-4'
                ],
                'constraints'=>new NotBlank(['message'=>"l'adresse de livraison est obligatoire"]),
            ])
            ->add('ville_livraison', TextType::class, [
                'label'=>false,
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'ville de livraison',
                    'class'=>'form-control text-dark'
                ],
                'constraints'=>new NotBlank(['message'=>"la ville de livraison est obligatoire"]),
            ])
            ->add('pays_livraison', TextType::class, [
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'pays de livraison',
                    'class'=>'form-control text-dark'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
