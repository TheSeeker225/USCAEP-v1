<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomPrd', TextType::class)
                ->add('presPrd', TextareaType::class)
                ->add('domPrd', ChoiceType::class,
                      ['choices' => ['Choisir un domaine' => null,
                                     'Agriculture' => 'Agriculture',
                                     'Elévage' => 'Elévage',
                                      'Transformation' => 'Transformation'], 'choices_as_values' => true])
                ->add('groupPrd', ChoiceType::class,
                      ['choices' => ['Choisir un groupe' => null,
                                     'Cultures de rente' => 'Cultures de rente',
                                     'Céréales' => 'Céréales',
                                     'Fruits' => 'Fruits',
                                     'Légumes' => 'Légumes',
                                     'Produits dérivés' => 'Produits dérivés'], 'choices_as_values' => true]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_produit';
    }


}
