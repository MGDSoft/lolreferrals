<?php

namespace MGD\BasicBundle\Controller;

use Ladybug\Processor\Doctrine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}/",requirements={"_locale" = "(en|es|de)"},defaults={"_locale" = "en"}, name="home")
     * @Template()
     */
    public function indexAction($_locale)
    {
		$this->setLocale($_locale);

	    $em = $this->getDoctrine()->getManager();

	    $repository = $this->getDoctrine()
		    ->getRepository('MGDBasicBundle:Noticia');

	    /** @var Doctrine\ORM\QueryBuilder */
	    $query = $repository->createQueryBuilder('n')
		    ->orderBy('n.fecha', 'DESC')
		    ->setMaxResults(5)
		    ->getQuery();

	    $noticias = $query->getResult();

	    return array('noticias'=>$noticias);
    }

	/**
	 * @Route("/pay-success/", name="pagado")
	 * @Template("MGDBasicBundle:Default:index.html.twig")
	 */
	public function pagadoAction()
	{
		$this->get('session')->getFlashBag()->add('success', '<b>Su pedido se realizo correctamente</b>,
	                Recibira un correo comunicandole su id de seguimiento  si tiene cualquier problema dirijase a
	                nuestra seccion de contacto. Gracias por su compra!'
		);

		$request=$this->getRequest();

		return $this->indexAction(
			($request->getLocale()) ? $request->getLocale() :$this->container->getParameter('locale')
		);
	}

	/**
	*/
	private function setLocale($locale)
	{
		/** @var $request Request */
		$request=$this->getRequest();

		if (!$request->getLocale())
		{
			$defaultLocale=$this->container->getParameter('locale');
			$request->setLocale($defaultLocale);
		}

	}
}
