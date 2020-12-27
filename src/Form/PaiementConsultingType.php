<?php

namespace App\Form;

use App\Entity\PaiementConsulting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaiementConsultingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomCarte',null,['label'=>'nom de la carte '])
            ->add('numCarte',null,['label'=>'numéro de la carte '])
            ->add('expiration',DateType::class,[
                'widget' => 'single_text',
                 'format' => 'yyyy-MM-dd'
            ])
            ->add('cvv'
            )
            
            ->add('submit',SubmitType::class,[
                 'label'=>'Payer','attr'=>['class'=>'btn btn-success', 'style'=>' padding:2%; width:30%; margin-top:3%']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaiementConsulting::class,
        ]);
    }
}
