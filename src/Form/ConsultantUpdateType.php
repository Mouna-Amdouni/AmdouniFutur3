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


class ConsultantUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('nom',null,['label'=>'Nom :  '])
            ->add('age')
            ->add('password')
            ->add('prenom',null,['label'=>'Prénom:  '])
            ->add('dateNaissance',DateType::class,[
                'widget' => 'single_text',
                 'format' => 'yyyy-MM-dd'
            ], ['label'=>'Date de naissance :  '])
            ->add('tel')
            ->add('adresse',null,['label'=>'Votre adresse :  '])
            ->add('genre',ChoiceType::class,array(
                'choices'=>array('Homme'=>true,'Femme'=>false)
            ),['label'=>'Genre :  '])
            ->add('cin')
            ->add("submit",SubmitType::class,[
                'label'=>'en tant que sonde'
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
