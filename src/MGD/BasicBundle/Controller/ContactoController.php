<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Contacto;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Form\ContactoType;
use MGD\BasicBundle\Form\PedidoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class ContactoController extends Controller
{

	/**
     * @Route("/es/contacto/",defaults={"_locale" = "es"}, name="contacto_es")
	 * @Route("/en/contact/", name="contacto_en", defaults={"_locale" = "en"})
	 * @Route("/de/kontakt/", name="contacto_de", defaults={"_locale" = "de"})
     * @Template()
     */
    public function indexAction(Request $request)
    {

	    $contacto = new Contacto();

	    $form   = $this->createForm(new ContactoType(), $contacto);

	    if ($request->getMethod() === 'POST')
	    {
		    $em = $this->getDoctrine()->getManager();

		    $form->bind($request);

		    $pedidoId=$form->get('pedidoId')->getData();

		    $contacto->setPedido(null);

		    if (!empty($pedidoId))
		    {
			    if ($pedido = $em->getRepository("MGDBasicBundle:Pedido")->find($pedidoId))
			    {
				    $contacto->setPedido($pedido);

			    }else{
				    $translated = $this->get('translator');
				    $error = new FormError(
					    $translated->trans("formularios.contacto.errors.codigo_referencia_no")
				    );
				    $form->get('pedidoId')->addError($error);
			    }

		    }

		    if ($form->isValid()) {

			    $em->persist($contacto);
			    $em->flush();

			    $this->enviarCorreo($contacto);

			    $this->get('session')->getFlashBag()->add('success', 'contacto.enviado');

			    $contacto = new Contacto();
			    $form   = $this->createForm(new ContactoType(), $contacto);
		    }
	    }

	    return array(
		    'contacto_form'   => $form->createView(),
	    );

    }

	private function enviarCorreo(Contacto $contacto)
	{
		$message = \Swift_Message::newInstance()
			->setSubject('Contacto de '.$contacto->getNombre().' '.$contacto->getPedido())
			->setTo($this->container->getParameter('email_contacto'))
			->setFrom($this->container->getParameter('email_app'))
			->setBody(
				$this->renderView(
					'MGDBasicBundle:Contacto:email.text.twig',
					array('contacto' => $contacto)
				)
			)
		;
		$this->get('mailer')->send($message);
	}


}
