<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomCarte')
            ->add('numCarte')
            ->add('expiration',DateType::class,[
                'widget' => 'single_text',
                 'format' => 'yyyy-MM-dd'
            ])
            ->add('cvv')
            
            ->add('submit',SubmitType::class,[
                'attr'=>['class'=>'btn btn-success', 'style'=>'margin-top:6%; margin-bottom:2%']
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
