<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Form\PedidoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PedidoController extends Controller
{

	/**
     * @Route("/en/order/",defaults={"_locale" = "en"}, name="pedido_en")
     * @Route("/es/encargar/", name="pedido_es")
     * @Template()
     */
    public function indexAction()
    {
	    $em = $this->getDoctrine()->getManager();

	    /** @var \MGD\BasicBundle\Entity\Articulo[] $articulos */
	    $articulos = $em->getRepository("MGDBasicBundle:Articulo")->findAll();

	    return array(
		    'articulos' => $articulos,
	    );

    }

	/**
	 * @Route("/order/completed/", name="pago_completado")
	 * @Template()
	 */
	public function completadoAction()
	{
		return array();
	}

	/**
	 * @Route("/order/canceled/", name="pago_cancelado")
	 * @Template()
	 */
	public function cancelAction()
	{
		return array();
	}



}
