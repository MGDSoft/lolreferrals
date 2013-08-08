<?php

namespace Orderly\PayPalIpnBundle\Controller;

use Orderly\PayPalIpnBundle\Document\IpnOrderItems;
use Orderly\PayPalIpnBundle\Entity\IpnOrders;
use Orderly\PayPalIpnBundle\OrderlyPayPalIpnBundle;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Orderly\PayPalIpnBundle\Ipn;
use Orderly\PayPalIpnBundle\Event as Events;
use MGD\BasicBundle\Entity\Articulo;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\DataConstants\EstadoEnum;

/*
 * Copyright 2012 Orderly Ltd 
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 *  Sample listener controller for IPN messages with twig email notification
 */
class VerificationController extends Controller
{
    
    public $paypal_ipn;

	/**
	 * @var Logger $log
	 */
	private $log;

    /**
     * @Route("/verify_order",name="validacion_ipn")
     * @Template()
     */
    public function indexAction()
    {
	    $request = $this->get('request');

	    $this->log = $this->get('logger');

	    $this->log->info('all parametters GET '.print_r($request->query->all(),true));
	    $this->log->info('all parametters POST '.print_r($request->request->all(),true));

        //getting ipn service registered in container
	    /** @var OrderlyPayPalIpnBundle paypal_ipn  */
        $this->paypal_ipn = $this->get('orderly_pay_pal_ipn');

	    //validate ipn (generating response on PayPal IPN request)
        if ($this->paypal_ipn->validateIPN())
        {
            // Succeeded, now let's extract the order
            $this->paypal_ipn->extractOrder();

            // And we save the order now (persist and extract are separate because you might only want to persist the order in certain circumstances).
            $this->paypal_ipn->saveOrder();

            // Now let's check what the payment status is and act accordingly
            if ($this->paypal_ipn->getOrderStatus() == Ipn::PAID)
            {

	            if (!$pedido = $this->insertarBD())
	            {
		            $this->log->addCritical("No se ha insertado el pedido arreglarlo urgente");
	            }

	            $this->enviarCorreo($pedido,$request->request->get('option_selection2'));
	            $this->enviarCorreo($pedido,$this->container->getParameter('email_contacto')); //copia
            }
        }
        else // Just redirect to the root URL
        {
            return $this->redirect('/');
        }
        $this->triggerEvent(Events\PayPalEvents::RECEIVED);

        $response = new Response();
        $response->setStatusCode(200);
        
        return $response;
    }
	private function  enviarCorreo(Pedido $pedido,$para)
	{
		//preparing message
		$message = \Swift_Message::newInstance()
			->setSubject($this->get('translator')->trans('pago.correo.asunto'))
			->setFrom($this->container->getParameter('email_contacto'), 'TEST')
			->setTo($para, "asd")
			->setBody($this->renderView('OrderlyPayPalIpnBundle:Default:confirmation_email.html.twig',
				// Prepare the variables to populate the email template:
				array(
			        'pedido' => $pedido,
				)
			), 'text/html')
		;
		//send message
		$this->get('mailer')->send($message);
	}

	private function  insertarBD()
	{
		$request = $this->get('request');

		$em = $this->getDoctrine()->getManager();

		/** @var IpnOrders $order  */
		$order = $this->paypal_ipn->getOrder();

		if (!$items = $this->paypal_ipn->getOrderItems())
		{
			$this->log->info('No contiene articulos el pedido');
			return false;
		}

		/** @var IpnOrderItems $item  */
		$item = $items[0];

		$idArticulo = $item->getItemNumber();
		$refenciaPaypal = $order->getReceiverId();
		$referralsLink = $request->request->get('option_selection1');
		$email = $request->request->get('option_selection2');

		$articulo = $em->getRepository('MGDBasicBundle:Articulo')->find($idArticulo);

		$entity  = new Pedido();
		$entity->setArticulo($articulo);
		$entity->setEmail($email);
		$entity->setReferralLink($referralsLink);
		$entity->setRefPaypal($refenciaPaypal);

		$estado = $em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);
		$entity->setEstado($estado);

		$em->persist($entity);

		$em->flush();

		$pedidoEstados  = new PedidoEstados();
		$pedidoEstados->setEstado($estado);
		$pedidoEstados->setPedido($entity);
		$em->persist($pedidoEstados);

		$em->flush();

		return $entity;
	}

    private function triggerEvent($event_name) {
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch($event_name, new Events\PayPalEvent($this->paypal_ipn));
    }
}
