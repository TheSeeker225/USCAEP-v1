<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use CoreBundle\Form\DepartementType;

class CooperativeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomCoop', TextType::class)
                ->add('sigleCoop', TextType::class)
                ->add('dateAdhCoop', DateType::class, ['widget' => 'single_text', 'attr' => ['class' => 'js-datepicker']])
                ->add('bPCoop', TextType::class)
                ->add('sPCoop', TextType::class)
                ->add('contCoop', TextType::class)
                ->add('departement', EntityType::class,
                        ['class' => 'CoreBundle:Departement',
                         'placeholder' => 'Choisir le département',
                         'choice_label' => 'nomDep'])
                ->add('descCoop', TextareaType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Cooperative'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_cooperative';
    }


}
