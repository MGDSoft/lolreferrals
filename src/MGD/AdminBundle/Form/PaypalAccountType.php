<?php

namespace MGD\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaypalAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('apiUsername')
            ->add('apiPassword')
            ->add('apiSignature')
            ->add('dineroParaRotar','money')
            ->add('active')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\BasicBundle\Entity\PaypalAccount'
        ));
    }

    public function getName()
    {
        return 'mgd_adminbundle_paypalaccounttype';
    }
}
