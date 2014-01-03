<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Contacto;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
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
    * @Route("/de/verfolgung/",defaults={"_locale" = "de"}, name="seguimiento_de")
    * @Template()
    */
    public function indexAction(Request $request)
    {
	    $seguimientoId = $pedido = $bots =null;
	    $seguimientos = array();
	    $form = $this->createForm(new SeguimientoType(), null);

	    if ($request->getMethod() === 'POST')
	    {
		    $em = $this->getDoctrine()->getManager();

		    $form->bind($request);

		    if ($form->isValid()) {

			    $seguimientoId=$form->get('pedidoId')->getData();

			    if (!empty($seguimientoId))
			    {
                    /** @var PedidoEstados[] $seguimientos */
				    if (!$seguimientos = $em->getRepository("MGDBasicBundle:PedidoEstados")->findByPedido($seguimientoId))
				    {
					    $translated = $this->get('translator');
					    $error = new FormError(
						    $translated->trans("formularios.contacto.errors.codigo_referencia_no")
					    );
					    $form->get('pedidoId')->addError($error);
				    }else{
                        $pedido=$seguimientos[0]->getPedido();
                        $bots=$pedido->getPedidoBots();
                    }


			    }
		    }
	    }

	    return array(
		    'seguimiento_form'   => $form->createView(),
		    'seguimientos'   => $seguimientos,
            'pedido'   => $pedido,
            'bots'   => $bots,
		    'seguimientoId' => $seguimientoId,
	    );

    }

}
