<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Contacto;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
use MGD\BasicBundle\Form\PedidoOpinionType;
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
        $seguimientoId = $pedido = $bots = $bots_n_per_page = $bots_n_pages = null;
        $seguimientos = array();
        $form = $this->createForm(new SeguimientoType(), null);

        $sessions=$request->getSession();

        if ($request->getMethod() === 'POST' || $sessions->has('tracking_id_remember')) {
            $em = $this->getDoctrine()->getManager();

            if ($request->getMethod() === 'POST')
                $form->bind($request);

            if ($sessions->has('tracking_id_remember') || $form->isValid() ) {

                $seguimientoId = ($form->get('pedidoId')->getData() ? $form->get('pedidoId')->getData() : $sessions->get('tracking_id_remember') );

                if (!empty($seguimientoId)) {

                    /** @var PedidoEstados[] $seguimientos */
                    if (!$seguimientos = $em->getRepository("MGDBasicBundle:PedidoEstados")->findByPedido($seguimientoId)){
                        $translated = $this->get('translator');
                        $error = new FormError($translated->trans("formularios.contacto.errors.codigo_referencia_no"));
                        $form->get('pedidoId')->addError($error);
                    } else {
                        $sessions->set('tracking_id_remember',$seguimientos[0]->getPedido()->getId());

                        $pedido = $seguimientos[0]->getPedido();
                        $bots = $pedido->getPedidoBots();

                    }


                    if ($bots) {
                        $bots_n_per_page = 20;
                        $bots_n_pages = ceil(($bots->count() + 1) / $bots_n_per_page);
                    }
                }

            }
        }


        return array(
            'seguimiento_form' => $form->createView(),
            'seguimientos'     => $seguimientos,
            'pedido'           => $pedido,
            'bots'             => $bots,
            'bots_n_pages'     => $bots_n_pages,
            'bots_n_per_page'  => $bots_n_per_page,
            'seguimientoId'    => $seguimientoId,

        );

    }

}
