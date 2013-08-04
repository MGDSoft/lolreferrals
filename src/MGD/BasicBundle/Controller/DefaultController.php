<?php

namespace MGD\BasicBundle\Controller;

use Ladybug\Processor\Doctrine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}/",defaults={"_locale" = "en"}, name="home")
     * @Template()
     */
    public function indexAction()
    {
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
}
