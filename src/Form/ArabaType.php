<?php

namespace App\Form;

use App\Entity\Araba;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArabaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image', FileType::class, [
        'label'=> 'Category Main Image',
                // unmapped means that this field is not associated to any entity property
        'mapped'=> false,
                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
        'required'=> false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
        'constraints' => [
            new File([
                'maxSize' => '4096k',
                'mimeTypes' => [
                    'image/*',
                ],
                'mimeTypesMessage' => 'Please upload a valid Image File',
            ])
        ],
    ])
            // ...

            ->add('rating',ChoiceType::class,[
                'choices'=>[
                    '1 rating'=>'1',
                    '2 rating'=>'2',
                    '3 rating'=>'3',
                    '4 rating'=>'4',
                    '5 rating'=>'5'],
                    ])

            ->add('address')
            ->add('phone')
            ->add('email')
            ->add('price')
            ->add('city')
            ->add('location')
            ->add('status', ChoiceType::class, [
                'choices'=> [
                    'True'=> 'True',
                    'False' => 'False'
                ],
            ])
            ->add('detail', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    //...
                ),
            ))

            ->add('category', EntityType::class, [
                'class'=> Category::class,
                'choice_label'=> 'title',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Araba::class,
            'csrf_protection'=> false,
        ]);
    }
}
