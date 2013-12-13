<?php
namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Contacto;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Form\ContactoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class ColaController extends Controller
{

    /**
     * @Template()
     */
    public function showViewAction(Request $request)
    {
        $repoCola = $this->getDoctrine()
            ->getRepository('MGDBasicBundle:Cola');

        $queue = $repoCola->find(1);

        return array('queue' => $queue);
    }
}