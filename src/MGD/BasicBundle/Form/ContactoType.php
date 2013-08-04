<?php

namespace MGD\BasicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('nombre','text',array(
		        'label'=> 'formularios.contacto.nombre.label',
		        'attr' => array(
			        'placeholder' => 'formularios.contacto.nombre.placeholder',
		        ),
	        ))
	        ->add('email','email',array(
		        'label'=> 'formularios.contacto.email.label',
		        'attr' => array(
			        'placeholder' => 'formularios.contacto.email.placeholder',
		        ),
	        ))
	        ->add('pedidoId','text',array(
		        'mapped' => false,
		        'required' => false,
		        'label'=> 'formularios.contacto.pedido.label',
		        'attr' => array(
			        'placeholder' => 'formularios.contacto.pedido.placeholder',
		        ),
	        ))
	        ->add('mensaje','textarea',array(
		        'label'=> 'formularios.contacto.mensaje.label',
		        'attr' => array(
			        'placeholder' => 'formularios.contacto.mensaje.placeholder',
		        ),
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
            'data_class' => 'MGD\BasicBundle\Entity\Contacto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mgd_basicbundle_contactotype';
    }
}
