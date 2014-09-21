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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use JMS\DiExtraBundle\Annotation as DI;

class BotsController extends Controller
{
    /**
     * @var ColaService
     *
     * @DI\Inject
     */
    protected $colaService;

    /**
     * @Route("/protected/get_bots/{maquina}/{numero}", requirements={"numero"= "\d+"})
     */
    public function indexAction(Request $request, $maquina, $numero)
    {
        $em = $this->getDoctrine()->getManager();
        $bots = $em->getRepository("MGDBasicBundle:PedidoBots")->getByPendientes($numero);

        $result= array();

        foreach ($bots as $bot)
        {
            $bot->setMaquina($maquina);
            $result[] = array('bot' => $bot->getNombre(), 'contrasena' => $bot->getContrasena(), 'level' => $bot->getLvl());
        }

        $em->flush();

        return new JsonResponse($result);
    }
}