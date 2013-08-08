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
     * @Route("/es/encargar/",defaults={"_locale" = "es"}, name="pedido_es")
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

}
