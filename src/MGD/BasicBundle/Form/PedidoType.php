<?php

namespace MGD\BasicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PedidoType extends AbstractType
{
    private $name='mgd_basicbundle_pedidotype';

    function __construct($id='')
    {
        $this->name .= $id;

    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nReferidos','integer',array(
                    'label'=> 'formularios.pedido.n_referidos.label',
                    'attr' => array(
                        'placeholder' => 'formularios.pedido.n_referidos.placeholder',
                        'min'=> '10',
                        'max' => '400',
                    )
                ))
            ->add('referralLink','text',array(
                    'label'=> 'formularios.pedido.referral_link.label',
                    'attr' => array(
                        'placeholder' => 'formularios.pedido.referral_link.placeholder',
                    )
                ))
            ->add('email','email',array(
                    'label'=> 'formularios.pedido.email.label',
                    'attr' => array(
                        'placeholder' => 'formularios.pedido.email.placeholder',
                    )
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

        return $this->name ;
    }
}
