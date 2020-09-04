<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use CoreBundle\Form\ImageType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;


class Union_coopType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomUn', TextType::class)
                ->add('siegeUn', TextType::class)
                ->add('eMailUn', EmailType::class)
                ->add('heurUn', TextType::class)
                ->add('telUn', TextType::class)
                ->add('presUn', TextareaType::class, array('attr' => array('class' => 'tinymce'),))
                ->add('histUn', TextareaType::class, array('attr' => array('class' => 'tinymce'),))
                ->add('objetUn', TextareaType::class, array('attr' => array('class' => 'tinymce'),))
                ->add('butUn', TextareaType::class, array('attr' => array('class' => 'tinymce'),))
                ->add('objectifUn', TextareaType::class, array('attr' => array('class' => 'tinymce'),))
                ->add('lnkFbUn', UrlType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Union_coop'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_union_coop';
    }


}
