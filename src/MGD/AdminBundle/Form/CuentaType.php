<?php

namespace MGD\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CuentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleTemplate')
            ->add('precio')
            ->add('influencePoints')
            ->add('level')
            ->add('descripcion','ckeditor')
            ->add('paypalAccount')
            ->add('file')
            ->add('objetosExtras', null, array('required'=> false))
            ->add('cuentaUsuarios', 'collection', array('type' => new CuentaUsuarioType(),'allow_add' => true,'allow_delete' => true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\BasicBundle\Entity\Cuenta'
        ));
    }

    public function getName()
    {
        return 'mgd_basicbundle_cuentatype';
    }
}
