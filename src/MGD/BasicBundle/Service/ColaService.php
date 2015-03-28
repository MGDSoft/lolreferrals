<?php

namespace MGD\BasicBundle\Service;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\ORM\EntityManager;
use JMS\Payment\CoreBundle\Entity\ExtendedData;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\PluginController\EntityPluginController;
use JMS\Payment\CoreBundle\PluginController\Result;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Cola;
use MGD\BasicBundle\Entity\Pedido;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\Session\Session;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ColaService
{
    /**
     * @var Logger $log
     */
    protected $log;

    /**
     * @var Session
     *
     */
    protected $session;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->session = $container->get('session');
        $this->log = $container->get('logger');
    }

    function setQueueRemainingDays(Cola $cola)
    {
        $cola->setQueueRemainingDays(
            $this->calculateQueueDaysRemainingFromDate(new \DateTime())
        );
    }

    function calculateQueueDaysRemainingFromDate(\DateTime $date)
    {
        $remainingReferrals = $this->em->getRepository('MGDBasicBundle:Pedido')->sumNReferrals($date);
        $queues=$this->em->getRepository('MGDBasicBundle:Cola')->findAll();
        $referralsPerDay = $queues[0]->getReferalsPerDay();

        return round($remainingReferrals/$referralsPerDay);
    }

}