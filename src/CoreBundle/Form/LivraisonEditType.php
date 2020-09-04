<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LivraisonEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('raisLiv', TextType::class)
                ->add('montPayLiv', NumberType::class)
                ->add('etatLiv', ChoiceType::class, ['choices' => array('Paiement en cours' => 'AT', 
                'Paiement terminé' => 'ET'), 'choices_as_values' => true])
                ->add('dateLiv', DateTimeType::class, 
                ['widget' => 'single_text', 'attr' => ['class' => 'js-datepicker']])
                ->add('membre',  EntityType::class,
                ['class' => 'CoreBundle:Membre', 'choice_label' => 'prenomMem']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Livraison'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_livraison';
    }


}
