<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Contacto;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Form\SeguimientoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class SeguimientoController extends Controller
{

	/**
     * @Route("/es/seguimiento/",defaults={"_locale" = "es"}, name="seguimiento_es")
	 * @Route("/en/tracking/",defaults={"_locale" = "en"}, name="seguimiento_en")
     * @Template()
     */
    public function indexAction(Request $request)
    {
	    $seguimientoId  =null;
	    $seguimientos = array();
	    $form   = $this->createForm(new SeguimientoType(), null);

	    if ($request->getMethod() === 'POST')
	    {
		    $em = $this->getDoctrine()->getManager();

		    $form->bind($request);

		    $seguimientoId=$form->get('pedidoId')->getData();

		    if (!empty($seguimientoId))
		    {
			    if (!$seguimientos = $em->getRepository("MGDBasicBundle:PedidoEstados")->findByPedido($seguimientoId, array('fecha' => 'desc')))
			    {
				    $translated = $this->get('translator');
				    $error = new FormError(
					    $translated->trans("formularios.contacto.errors.codigo_referencia_no")
				    );
				    $form->get('pedidoId')->addError($error);
			    }

		    }

	    }

	    return array(
		    'seguimiento_form'   => $form->createView(),
		    'seguimientos'   => $seguimientos,
		    'seguimientoId' => $seguimientoId,
	    );

    }

}
