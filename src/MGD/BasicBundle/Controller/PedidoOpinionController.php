<?php
namespace MGD\BasicBundle\Controller;

use Doctrine\ORM\EntityManager;
use Ivory\CKEditorBundle\Exception\Exception;
use MGD\BasicBundle\Entity\Contacto;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoOpinion;
use MGD\BasicBundle\Form\ContactoType;
use MGD\BasicBundle\Form\PedidoOpinionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class PedidoOpinionController extends Controller
{

    /**
     * @Route("/order-opinion/update/{pedidoId}", name="order_opinion_update")
     * @Template()
     */
    public function updateAction(Request $request, $pedidoId)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MGDBasicBundle:PedidoOpinion');

        if (!$pedido = $em->getRepository('MGDBasicBundle:Pedido')->find($pedidoId))
        {
            throw new Exception('Order doesnt exist');
        }
        $sessions = $request->getSession();

        if ($pedido->getId() != $sessions->get('tracking_id_remember'))
        {
            throw new Exception('Required permissions');
        }

        /** @var PedidoOpinion $pedidoOpinion */
        if (!$pedidoOpinion = $repo->findOneByPedido($pedidoId))
        {
            $pedidoOpinion = new PedidoOpinion();
            $pedidoOpinion->setEmail($pedido->getEmail());
            $pedidoOpinion->setPedido($pedido);
        }

        $form = $this->createForm(new PedidoOpinionType(), $pedidoOpinion);

        if ($request->getMethod() === 'POST') {

            $form->bind($request);

            if ($form->isValid() ) {

                $em->persist($pedidoOpinion);
                $em->flush();

            }else{

                $this->get('session')->getFlashBag()->add('danger',$form->getErrorsAsString());
            }

            $referer = $request->headers->get('referer');

            return new RedirectResponse($referer);
        }

        return array(
            'pedido_opinion_form' => $form->createView(),
            'pedido' => $pedido,
        );

    }

    /**
     * @Template()
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $opinions = $em->getRepository('MGDBasicBundle:PedidoOpinion')->findBy(array(), array('created'=>'DESC'), 5);

        return array(
            'opinions' => $opinions
        );
    }

}
