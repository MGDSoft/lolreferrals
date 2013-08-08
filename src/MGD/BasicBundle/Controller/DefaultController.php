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
		$request=$this->getRequest();

		$return = $this->indexAction(
			($request->getLocale()) ? $request->getLocale() :$this->container->getParameter('locale')
		);

		$this->get('session')->getFlashBag()->add('success',
			$this->get('translator')->trans('pago.finalizado')
		);

		return $return;

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
