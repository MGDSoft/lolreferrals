<?php

namespace MGD\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ColaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('days',null,array(
                    'label'=> 'N Referrals'
                ))
            ->add('text','ckeditor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\BasicBundle\Entity\Cola'
        ));
    }

    public function getName()
    {
        return 'mgd_basicbundle_colatype';
    }
}
