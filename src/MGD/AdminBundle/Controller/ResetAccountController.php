<?php

namespace MGD\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use MGD\BasicBundle\Entity\Articulo;
use MGD\AdminBundle\Form\ArticuloType;
use MGD\AdminBundle\Form\ArticuloFilterType;

/**
 * Articulo controller.
 *
 * @Route("/reset_account" )
 */
class ResetAccountController extends Controller
{
    /**
     * Lists all Articulo entities.
     *
     * @Route("/", name="reset_account_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        if ($request->getMethod() == 'POST')
        {
            $this->updateBotsRefseu($request->get('bots'));
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');
        }

        return array(

        );
    }


    /**
     * @param $bots
     */
    private function updateBotsRefseu($bots)
    {
        $bots = explode("\n" ,$bots);

        foreach ($bots as $bot)
        {
            $bot = explode(":", $bot);
            /** @var EXTRefseu $bot */
            if ($bot = $this->getDoctrine()->getRepository("MGDBasicBundle:EXT\EXTRefseu")->findOneByUsername($bot))
            {
                $bot->setFinished(0);
                $bot->setProgress(0);
            }
        }

        $this->getDoctrine()->getManager()->flush();
    }
}
