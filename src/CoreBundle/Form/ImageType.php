<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class)
            ->add('altImg', TextType::class)
            ->add('dirImg', ChoiceType::class,
                ['choices' => array('Carousel' => 'carousel', 
                                    'Coopératives' => 'cooperatives',
                                    'Produits' => 'produits',
                                    'Unions' => 'unions',
                                    'Autres' => 'others',
                                    'Employés' => 'employes',
                                    'Membres' => 'membres',
                                    'Utilisateurs' => 'users'), 'choices_as_values' => true])
            ->add('onlImg', ChoiceType::class, 
                ['choices' => array('Mettre en ligne' => true, 
                                    'Hors ligne' => false), 'choices_as_values' => true])
            ->add('descImg', TextareaType::class);
    } 
                      

    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver->setDefaults(array(
    		'data_class' => 'CoreBundle\Entity\Image',
    	));
    }
}
