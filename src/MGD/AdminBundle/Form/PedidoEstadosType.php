<?php

namespace MGD\AdminBundle\Form;

use MGD\BasicBundle\DataConstants\EstadoEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PedidoEstadosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pedido', 'entity', array(
		        'class' => 'MGDBasicBundle:Pedido',
		        'query_builder' => function(EntityRepository $er){
			        return $er->createQueryBuilder('p')
				        ->orderBy('p.fecha', 'DESC')
			            ->setMaxResults(20);
		            },
	            )
	        )
            ->add('estado', 'entity', array(
			        'class' => 'MGDBasicBundle:Estado',
			        'property' => 'nombre',
		        )
	        )
	        ->add('descripcion', 'ckeditor', array(
	            'config' => array(
				    'toolbar' => array(
					    array(
						    'name'  => 'document',
						    'items' => array('Source'),
				        )
				    )
	            )
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\BasicBundle\Entity\PedidoEstados'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mgd_adminbundle_pedidoestadostype';
    }
}
