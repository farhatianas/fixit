<?php

namespace OfferBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OfferType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nameoffer')
            ->add('placeoffer')
            ->add('priceoffer')
            ->add('descriptionoffer', TextareaType::class)
            ->add('imageFile', VichImageType::class)
            ->add('categoryoffer', EntityType::class, array('class' =>'OfferBundle:Categorie', 'choice_label' => 'nom', 'multiple' => false))
            ->add('submit',SubmitType::class) ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OfferBundle\Entity\Offer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'offerbundle_offer';
    }


}
