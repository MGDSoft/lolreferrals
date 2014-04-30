<?php
namespace MGD\BasicBundle\Controller;

use Faker\Provider\DateTime;
use MGD\BasicBundle\Entity\Contacto;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Form\ContactoType;
use MGD\BasicBundle\Service\ColaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use JMS\DiExtraBundle\Annotation as DI;

class ColaController extends Controller
{
    /**
     * @var ColaService
     *
     * @DI\Inject
     */
    protected $colaService;

    /**
     * @Template()
     */
    public function showViewAction(Request $request)
    {
        $queue = $this->getDoctrine()->getRepository('MGDBasicBundle:Cola')->find(1);

        $this->colaService->setQueueRemainingDays($queue);

        return array('queue' => $queue);
    }
}