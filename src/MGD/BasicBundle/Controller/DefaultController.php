<?php

namespace MGD\BasicBundle\Controller;

use Ladybug\Processor\Doctrine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * @Cache(expires="+360 secs", public=true)
     * @Route("/{_locale}/",requirements={"_locale" = "(en|es|de)"},defaults={"_locale" = "en"}, name="home")
     * @Template()
     */
    public function indexAction($_locale)
    {
        $repository = $this->getDoctrine()->getRepository('MGDBasicBundle:Noticia');

        /** @var Doctrine\ORM\QueryBuilder */
        $query = $repository->createQueryBuilder('n')->orderBy('n.fecha', 'DESC')->setMaxResults(5)->getQuery();

        $repoCola = $this->getDoctrine()->getRepository('MGDBasicBundle:Cola');

        $queue = $repoCola->find(1);

        $noticias = $query->getResult();

        return array('noticias' => $noticias, 'queue' => $queue);
    }

    /**
     * @Route("/pay-success/{_locale}",requirements={"_locale" = "(en|es|de)"}, name="pagado")
     * @Template("MGDBasicBundle:Default:index.html.twig")
     */
    public function pagadoAction()
    {
        $request = $this->getRequest();

        $return = $this->indexAction(
            ($request->getLocale()) ? $request->getLocale() : $this->container->getParameter('locale')
        );

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('pago.finalizado')
        );

        return $return;

    }

}
