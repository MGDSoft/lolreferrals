<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Pedido;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class FaqController extends Controller
{

    /**
     * @Cache(expires="+360 secs", public=true)
     * @Route("/en/faq/",defaults={"_locale" = "en"}, name="faq_en")
     * @Route("/es/faq/",defaults={"_locale" = "es"}, name="faq_es")
     * @Route("/de/hilfe/",defaults={"_locale" = "de"}, name="faq_de")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

}
