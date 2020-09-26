<?php

namespace App\Form;

use App\Entity\Araba;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
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
            ->add('araba', EntityType::class, [
                'class' => Araba::class,
                'choice_label' => 'title'
            ]);

    }

    public
        /**
         * @param OptionsResolver $resolver
         */
        function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'csrf_protection'=> false,
        ]);
    }
}
