<?php

namespace MGD\BasicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class PedidoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referralLink','text',array(
                    'label'=> 'Referral-Link',
                    'attr' => array(
                        'placeholder' => 'Url Referral-Link',
                    ),
                    'constraints' => array(
                        new NotBlank(),
                    ),
                ))
            ->add('email','email',array(
                    'label'=> 'formularios.contacto.email.label',
                    'attr' => array(
                        'placeholder' => 'formularios.contacto.email.placeholder',
                    ),
                    'constraints' => array(
                        new NotBlank(),
                        new Email(),
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
