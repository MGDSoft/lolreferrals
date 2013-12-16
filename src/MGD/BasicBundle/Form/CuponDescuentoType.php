<?php

namespace MGD\BasicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CuponDescuentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $opciones = array('valor','porcentaje');

        $builder
            ->add('id','text',array(
                    'required' => true,
                    'mapped' => false,
                    'label'=> 'formularios.descuento.codigo.label',
                    'attr' => array(
                        'placeholder' => 'formularios.descuento.codigo.placeholder',
                    ),
                ))
            ->add('captcha', 'captcha',array(
                    'label'=> false,
                    'attr' => array(
                        'placeholder' => 'formularios.contacto.captcha.placeholder',
                    ),
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    public function getName()
    {
        return 'mgd_basicbundle_cupondescuentotype';
    }
}
