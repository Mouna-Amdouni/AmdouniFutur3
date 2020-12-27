<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EnqueteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',null,['label'=>"Nom du responsable :"])
        ->add('prenom',null,['label'=>"Prenom du responsable :"])
          ->add('email',EmailType::class,['label'=>"Email de l'entreprise"])
            ->add('password',PasswordType::class,['label'=>'Mot de passe'])
            ->add('dateNaissance',DateType::class,[
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ], ['label'=>'Date de Naissance  :  '])
            ->add('tel',TelType::class,['label'=>'Numéro de téléphone du responsable  :'])
            ->add('matriculeFiscale',null,['label'=>'Matricule Fiscale'])
            ->add('registreDesCommerces',FileType::class,['label'=>'Registre des commerces'], array('data_class' => null))
            ->add('adresse',null,['label'=>"Adresse postale  :"])
            ->add('image',FileType::class,['label'=>"Logo de l'entreprise : "] ,array('data_class' => null))
            ->add('cin',null,['label'=>'Numero cin du responsable :'])
            ->add('submit',SubmitType::class,['label'=>"S'inscrire"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
