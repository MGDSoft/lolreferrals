<?php
/**
 * Created by lol.
 * User: PC
 * Date: 13/12/13
 * Time: 7:45
 */

namespace MGD\BasicBundle\Service;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\ORM\EntityManager;
use JMS\Payment\CoreBundle\Entity\ExtendedData;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\PluginController\EntityPluginController;
use JMS\Payment\CoreBundle\PluginController\Result;
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



class PedidoPagoService
{
    /**
     * @var EntityPluginController
     */
    protected $ppc;

    /**
     * @var Logger $log
     */
    protected $log;

    /**
     * @var Router
     *
     */
    protected $router;

    /**
     * @var Session
     *
     */
    protected $session;

    /**
     * @var Container
     */
    private $container;

    function __construct(Container $container)
    {
        $this->container = $container;
        $this->session = $container->get('session');
        $this->log = $container->get('logger');
        $this->ppc = $container->get('payment.plugin_controller');
        $this->router = $container->get('router');
    }


    function generateInstructions(Pedido $pedido)
    {
        // Create the extended data object
        $extendedData = new ExtendedData();

        // Complete payment return URL
        $extendedData->set('return_url',
            $this->router->generate('payment_complete_mgd', array(
                    'pedido_id' => $pedido->getId(),
                ), true)
        );

        // Cancel payment return URL
        $extendedData->set('cancel_url',
            $this->router->generate('payment_cancel_mgd', array(
                    'pedido_id' => $pedido->getId(),
                ), true)
        );

        // Checkout parameters
        $checkout_params = $this->generateCheckoutParameters($pedido);
        $this->log->info(print_r($checkout_params, 1));

        // Add checkout information to the exended data
        $extendedData->set('checkout_params', $checkout_params);

        // Create the payment instruction object
        $instruction = new PaymentInstruction(
            $pedido->getTotal(), 'EUR', 'paypal_express_checkout', $extendedData
        );

        // Validate and persist the payment instruction
        $this->ppc->createPaymentInstruction($instruction);

        return $instruction;
    }

    protected function generateCheckoutParameters(Pedido $pedido)
    {
        // Checkout parameters
        $checkout_params = array();


        $articulo = $pedido->getArticulo();

        $checkout_params = array_merge(
            $checkout_params,
            array(
                sprintf('L_PAYMENTREQUEST_0_NAME%d', 0)   => $articulo->getNombre(),
                sprintf('L_PAYMENTREQUEST_0_DESC%d', 0)   => $articulo->getNombre(),
                sprintf('L_PAYMENTREQUEST_0_AMT%d', 0)    => $pedido->getTotal(),
                sprintf('L_PAYMENTREQUEST_0_QTY%d', 0)    => 1,
            )
        );


        // Include payments data in the order
        $checkout_params = array_merge(
            $checkout_params,
            array(
                'PAYMENTREQUEST_0_DESC'     => "Order #".$pedido->getId(),
                'PAYMENTREQUEST_0_INVNUM'   => $pedido->getId(),
            )
        );

        return $checkout_params;
    }

    public function verifyPaymentCompleted(Pedido $pedido)
    {
        $instruction = $pedido->getPaymentInstruction();
        if (null === $pendingTransaction = $instruction->getPendingTransaction()) {
            $payment = $this->ppc->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
        } else {
            $payment = $pendingTransaction->getPayment();
        }

        $result = $this->ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
        if (Result::STATUS_PENDING === $result->getStatus()) {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    // Redirect to paypal
                    return $action->getUrl();
                }

                throw $ex;
            }

            //throw new \RuntimeException('something was wrong');
        } else if (Result::STATUS_SUCCESS !== $result->getStatus()) {

            if ($result->getReasonCode() == "10445" || $result->getReasonCode() == "10486")
            {
                $this->session->getFlashBag()->add('error','The price could not be charged. Payment failed due to a bad funding
                    method (typically an invalid or maxed out credit card), choose other account/method to pay');

                $this->log->addCritical("EmailUser: ".$pedido->getEmail().", Id: ".$pedido->getId().", Payment error: "
                    .$result->getReasonCode());

                return $this->router->generate('pedido_'.
                    ($this->session->get('_locale') ? $this->session->get('_locale') : $this->container->getParameter('locale') ));
            }
            throw new \RuntimeException('Transaction was not successful: '.$result->getReasonCode());
        }

        return true;
    }


}