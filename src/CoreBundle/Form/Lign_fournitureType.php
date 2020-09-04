<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use CoreBundle\Form\LivraisonType;

class Lign_fournitureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('qteFrLiv', NumberType::class)
                ->add('paPrdLiv', MoneyType::class, ['currency' => false ])
                ->add('qualPrdLiv', ChoiceType::class,
                                ['choices' => array('Aucun' => 'N', 'Grade A' => 'A', 'Grade B' => 'B', 'Grade C' => 'C',), 'choices_as_values' => true])
                ->add('livraison', LivraisonType::class)
                ->add('produit', EntityType::class,
                                ['class' => 'CoreBundle:Produit', 'choice_label' => 'nomPrd']);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Lign_fourniture'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_lign_fourniture';
    }


}
