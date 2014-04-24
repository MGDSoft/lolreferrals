<?php

namespace MGD\BasicBundle\Controller;


use MGD\BasicBundle\Entity\CuponDescuento;
use MGD\BasicBundle\Form\CuponDescuentoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\Translator;

class CuponDescuentoController
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;


    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->request = $container->get("request");
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->formFactory = $container->get('form.factory');
    }

    public function indexForm()
    {
        $form = $this->formFactory->create(new CuponDescuentoType());

        if (!$this->request->get('mgd_basicbundle_cupondescuentotype')) {
            return $form;
        }

        $form->handleRequest($this->request);

        if ($form->isValid()) {
            /** @var Translator $translated */
            $translated = $this->container->get('translator');

            if (!$cuponDescuento = $this->em->getRepository("MGDBasicBundle:CuponDescuento")->find(
                $form->get('id')->getData()
            )
            ) {
                $form->get('id')->addError(
                    new FormError($translated->trans("formularios.descuento.errors.codigo_invalido"))
                );

                return $form;
            }

            if (!$cuponDescuento->validarCupon()) {
                $form->get('id')->addError(
                    new FormError($translated->trans("formularios.descuento.errors.codigo_invalido"))
                );

                return $form;
            }

            $this->serializarObj($cuponDescuento);
            $this->request->getSession()->getFlashBag()->add(
                'success',
                $translated->trans('formularios.descuento.activado', array('%descuento%' => $cuponDescuento))
            );
        }

        return $form;
    }


    protected function serializarObj($obj)
    {
        $serializer = $this->container->get('jms_serializer');
        $out = $serializer->serialize($obj, 'json');

        $this->request->getSession()->set('cuponDescuento', $out);
    }

}