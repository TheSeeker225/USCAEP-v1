<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class)
                ->add('password', RepeatedType::class, 
                                ['type' => PasswordType::class, 
                                'invalid_message' => 'Les mots de passe ne sont pas identiques.',
                                'options' => array('attr' =>['class' => 'password-field']),
                                'required' => true,
                                'first_options' => array('label' => 'Mot de passe'),
                                'second_options' => array('label' => 'Répéter le mot de passe')])
                ->add('isActive')
                ->add('salt')
                ->add('roles')
                ->add('email', EmailType::class)
                ->add('nomUser', TextType::class)
                ->add('prenomUser', TextType::class)
                ->add('dateNaisUser', BirthdayType::class, 
                                    ['widget' => 'single_text', 
                                    'attr' => ['class' => 'js-datepicker']])
                ->add('lieuNaisUser', TextType::class)
                ->add('nationUser', CountryType::class)
                ->add('sexeUser', ChoiceType::class, 
                                ['choices' => array('Masculin' => 'M', 
                                'Feminin' => 'F',), 'choices_as_values' => true])
                ->add('posteUser', TextType::class)
                ->add('residUser', TextType::class)
                ->add('contUser', TextType::class)
                ->add('image', EntityType::class, 
                                ['class' => 'CoreBundle:Image', 'choice_label' => 'altImg'])
                ->add('union_coop', EntityType::class, 
                                    ['class' => 'CoreBundle:Union_coop', 'choice_label' => 'nomUn'])
                ->add('cooperative', EntityType::class, 
                                    ['class' => 'CoreBundle:Cooperative', 'choice_label' => 'nomCoop']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_user';
    }


}
