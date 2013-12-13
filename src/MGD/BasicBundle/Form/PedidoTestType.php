<?php

namespace MGD\BasicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoTestType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('articulo', 'entity', array(
		        'class' => 'MGDBasicBundle:Articulo',
		        'property' => 'nombre',
	        ))
            ->add('nombre','text',array(
                'label'=> 'Referral-Link',
                'attr' => array(
                    'placeholder' => 'Referral-Link',
                ),
            ))
            ->add('email','email',array(
                'label'=> 'formularios.contacto.email.label',
                'attr' => array(
                    'placeholder' => 'formularios.contacto.email.placeholder',
                ),
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
        return 'mgd_basicbundle_pedidotest';
    }
}
