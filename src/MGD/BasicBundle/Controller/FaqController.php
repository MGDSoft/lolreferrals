<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Form\PedidoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FaqController extends Controller
{

	/**
     * @Route("/en/faq/",defaults={"_locale" = "en"}, name="faq_en")
	 * @Route("/es/faq/",defaults={"_locale" = "es"}, name="faq_es")
     * @Template()
     */
    public function indexAction()
    {

	    return array(

	    );

    }

}
