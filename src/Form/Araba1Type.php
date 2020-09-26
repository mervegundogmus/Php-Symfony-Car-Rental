<?php

namespace App\Form;

use App\Entity\Araba;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Araba1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image', FileType::class, [
                'label'=>'Category Image',
                'mapped'=>false,
                'required'=>false,
                'constraints'=> [
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypes'=>[
                            'image/*',
                        ],
                        'mimeTypesMessage'=> 'Please upload a valid Image File',
                    ])
                ],
            ])
            ->add('rating')
            ->add('address')
            ->add('phone')
            ->add('email')



            ->add('status', ChoiceType::class,[
                'choices'=> [
                    'auto'=>'auto',
                    'manual'=>'manual',
                ],

            ])

            ->add('detail', CKEditorType::class, array(
                'config'=>array(
                    'uiColor'=>'#ffffff',
                    //...
                ),
            ))
            ->add('userid')
         ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Araba::class,
        ]);
    }
}
