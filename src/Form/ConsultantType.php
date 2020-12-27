<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,['label'=>'Entrez votre adresse E-mail '])
            ->add('nom',null,['label'=>'Nom :  '])
            ->add('age')
            ->add('password',PasswordType::class,['label'=>'Entrez votre mot de passe :  ','required'=>false])
            ->add('prenom',null,['label'=>'Entrez votre prénom:  '])
            ->add('dateNaissance',DateType::class,[
                'widget' => 'single_text',
                 'format' => 'yyyy-MM-dd'
            ], ['label'=>'Entrez votre date de naissance :  '])
            ->add('tel')
            ->add('adresse',null,['label'=>'Entrez votre  adresse postale :  '])
            ->add('genre',ChoiceType::class,array(
                'choices'=>array('Homme'=>true,'Femme'=>false)
            ),['label'=>'Genre :  '])
            ->add('cin',null,['label'=>'Entrez votre cin'])
            ->add("submit",SubmitType::class,[
                'label'=>'S\'inscrire'
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
