<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomClt', TextType::class)
                ->add('raisSocClt', ChoiceType::class, ['choices' => array('Société anonyme' => 'SA', 
                                                 'Société à nom commandite' => 'SNC', 'Société à responsabilité limitée' => 'SARL', 'Société publique' => 'Etat','Autre raison sociale' => 'NC'), 'choices_as_values' => true])
                ->add('siegeClt', TextType::class)
                ->add('paysClt', CountryType::class)
                ->add('telClt', TextType::class)
                ->add('emailClt', EmailType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_client';
    }


}
