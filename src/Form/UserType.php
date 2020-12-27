<?php

namespace App\Form;

use App\Entity\User;
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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',null,['label'=>'Nom :  '])
        ->add('prenom',null,['label'=>'Prénom :  '])
        ->add('adresse',null,['label'=>'Adresse postale :  '])
        
        ->add('email',EmailType::class,['label'=>'E-mail :  '])
        ->add('password',PasswordType::class,['label'=>'Mot de passe :  ','required'=>false])
        ->add('cin',null,['label'=>'Cin :  '])
        ->add('tel',TelType::class,['label'=>'Votre numéro de téléphone :  '])
        ->add('dateNaissance',DateType::class,[
            'widget' => 'single_text',
             'format' => 'yyyy-MM-dd'
        ], ['label'=>'Date de naissance :  '])
        ->add('genre',ChoiceType::class,array(
            'choices'=>array('Homme'=>true,'Femme'=>false)
        ),['label'=>'Genre :  '])
       
        ->add('save_sonde', SubmitType::class,[
            'label'=>'Inscription'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
