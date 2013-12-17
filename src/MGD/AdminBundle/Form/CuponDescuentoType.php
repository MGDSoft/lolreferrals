<?php

namespace MGD\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;

class CuponDescuentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $opciones = array('valor','porcentaje');

        $builder
            ->add('valor')
            ->add('porcentajeBoo','choice',
                array(
                    'label' => false,
                    'choices' => $opciones,
                    'multiple' => false,
                    'expanded' => true,
                ))
            ->add('nUsos',null,array('label' => 'Nº de usos'))
            ->add('expiracionDate')
            ->add('copias','number',array(
                    'mapped' => false,
                    'data' => 1,
                    'constraints' => array(
                        new NotBlank(),
                        new Range(array(
                                'min'        => 1,
                                'max'        => 100,
                        )),
                    ),
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\BasicBundle\Entity\CuponDescuento'
        ));
    }

    public function getName()
    {
        return 'mgd_adminbundle_cupondescuentotype';
    }
}
