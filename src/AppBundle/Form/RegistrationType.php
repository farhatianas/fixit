<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName');
        $builder->add( 'lastName');
        $builder->add( 'phoneNumber');
        $builder->add( 'birthDate');
        $builder->add('accountType', ChoiceType::class, [
            'choices'  => [
                'Client' => 'Client',
                'Professional' => 'Professional',
                'Enterprise' => 'Enterprise',
            ],
        ]);
        $builder->add( 'city');
        $builder->add( 'address');
        $builder->add( 'zipCode');
        $builder->add( 'newsLetterSubscribtion');
        $builder->add( 'volunteer');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}