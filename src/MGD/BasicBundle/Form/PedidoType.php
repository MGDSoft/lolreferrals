<?php

namespace MGD\BasicBundle\Form;

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
	        ->add('articulo', 'entity', array(
		        'class' => 'MGDBasicBundle:Articulo',
		        'property' => 'nombre',
	        ))
	        ->add('captcha', 'captcha',array(
		        'label'=> false,
		        'attr' => array(
			        'class' => 'captcha',
			        'placeholder' => 'formularios.contacto.captcha.placeholder',
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
        return 'mgd_adminbundle_pedidotype';
    }
}
