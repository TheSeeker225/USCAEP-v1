<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use CoreBundle\Form\ProduitType;

class FigurerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    private $tab = ['null' => 'Choisir la quantité'];
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        for ($i=10; $i < 1010; $i+=10) 
        { 
            $tab[$i] = $i;
        }

        $builder->add('qteCmdPrd', ChoiceType::class, ['choices' => $tab, 'choices_as_values' => true])
                ->add('Ajouter', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Figurer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_figurer';
    }


}
