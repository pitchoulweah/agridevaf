<?php

namespace App\Form;

use App\Entity\MessageClient;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=>false,
                'attr'=>[
                    'id'=>'name',
                    'placeholder'=>'votre nom',
                    'name'=>'name',
                    'class'=>'form-control pt-4 pb-4'
                ],
                'required'=>true,
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Saisissez votre nom'
                        ])
                ]
            ])
            ->add('email', TextType::class, [
                'label'=>false,
                'attr'=>[
                    'id'=>'email',
                    'placeholder'=>'votre email',
                    'name'=>'name',
                    'class'=>'form-control pt-4 pb-4'
                ],
                'required'=>true,
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Saisissez votre email'
                    ])
                ]
            ])
            ->add('telephone', TextType::class, [
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'votre numéro de téléphone',
                    'class'=>'form-control pt-4 pb-4'
                ],
                'required'=>true,
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Saisissez votre numéro de téléphone mobile'
                    ])
                ]
            ])
            ->add('sujet', TextType::class, [
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'le sujet de votre message',
                    'class'=>'form-control pt-4 pb-4'
                ],
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Qauel est le sujet de votre demande ?'
                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'label'=>false,
                'attr'=>[
                    'style'=>'height:200px',
                    'placeholder'=>'votre message',
                    'class'=>'form-control pt-4 pb-4'
                ],
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Saisissez votre message SVP'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MessageClient::class,
        ]);
    }
}
