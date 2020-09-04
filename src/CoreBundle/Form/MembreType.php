<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use CoreBundle\Form\ImageType;

class MembreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomMem', TextType::class)
                ->add('prenomMem', TextType::class)
                ->add('dateNaisMem', BirthdayType::class, 
                                    ['widget' => 'single_text', 
                                    'attr' => ['class' => 'js-datepicker']])
                ->add('lieuNaisMem', TextType::class)
                ->add('nationMem', CountryType::class)
                ->add('nbEnfMem', NumberType::class)
                ->add('villageMem', TextType::class)
                ->add('contMem', TextType::class)
                ->add('sexeMem', ChoiceType::class, ['choices' => array('Masculin' => 'M', 
                                                 'Feminin' => 'F',), 'choices_as_values' => true])
                ->add('image', EntityType::class, 
                                ['class' => 'CoreBundle:Image', 'choice_label' => 'altImg']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Membre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_membre';
    }


}
