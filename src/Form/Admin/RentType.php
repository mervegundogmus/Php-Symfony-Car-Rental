<?php

namespace App\Form\Admin;

use App\Entity\Admin\Rent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('userid')
        ->add('carid')
        ->add('name')
        ->add('surname')
        ->add('email')
        ->add('phone')
        ->add('day')
        ->add('totalprice')
        ->add('message')
        ->add('adress')
        ->add('note')
        ->add('status',ChoiceType::class,[
            'choices' => [
                'New' => 'New',
                'Accepted' => 'Accepted',
                'Canceled' => 'Canceled',
                'Completed' => 'Completed',
                 ]
        ])
        ->add('price')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rent::class,
        ]);
    }
}
