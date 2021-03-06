<?php

namespace MGD\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('precioRango', 'entity', array(
                'class' => 'MGDBasicBundle:PrecioRango',
                'property' => 'limite',
            ))
            ->add('nReferidos')
            ->add('referralLink')
            ->add('email')
            ->add('refPaypal')
            ->add('fecha','datetime', array(
                    'attr'=> array('class' => 'div-date'),
                )
            )
            ->add('bots','file',array(
                'mapped' => false,
                'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\BasicBundle\Entity\Pedido'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mgd_adminbundle_pedidotype';
    }
}
