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
