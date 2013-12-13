<?php
/**
 * Created by lol.
 * User: PC
 * Date: 13/12/13
 * Time: 7:45
 */

namespace MGD\BasicBundle\Listener;

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


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class PedidoPago
{
    /**
     * @var EntityPluginController
     *
     * @DI\Inject("payment.plugin_controller")
     */
    protected $ppc;

    /**
     * @var Logger $log
     *
     * @DI\Inject("logger")
     */
    protected $log;

    /**
     * @var Router
     *
     * @DI\Inject
     */
    protected $router;

    function __construct(EntityPluginController $ppc,Logger $log,Router $router)
    {
        $this->log = $log;
        $this->ppc = $ppc;
        $this->router = $router;
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
                sprintf('L_PAYMENTREQUEST_0_AMT%d', 0)    => $articulo->getPrecio(),
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
            throw new \RuntimeException('Transaction was not successful: '.$result->getReasonCode());
        }

        return true;
    }


}