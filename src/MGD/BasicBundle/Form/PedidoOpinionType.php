<?php

namespace MGD\BasicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoOpinionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array(
                'label'=> 'formularios.opinion.name.label',
                'attr' => array(
                    'placeholder' => 'formularios.opinion.name.placeholder',
                    'maxlength' => '24',
            )))
            ->add('email','email', array(
                    'label'=> 'formularios.opinion.email.label',
                    'attr' => array(
                        'placeholder' => 'formularios.opinion.email.placeholder',

            )))
            ->add('text','textarea', array(
                    'label'=> 'formularios.opinion.text.label',
                    'attr' => array(
                        'placeholder' => 'formularios.opinion.text.placeholder',
                        'maxlength'=> '149'
            )))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\BasicBundle\Entity\PedidoOpinion'
        ));
    }

    public function getName()
    {
        return 'mgd_basicbundle_pedidoopiniontype';
    }
}
