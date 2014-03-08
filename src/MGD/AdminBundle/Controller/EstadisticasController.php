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

use MGD\BasicBundle\Entity\PaypalAccountsPayment;
use MGD\AdminBundle\Form\PaypalAccountsPaymentType;
use MGD\AdminBundle\Form\PaypalAccountsPaymentFilterType;

/**
 * PaypalAccountsPayment controller.
 *
 * @Route("/estadisticas")
 */
class EstadisticasController extends Controller
{
    /**
     * Lists all PaypalAccountsPayment entities.
     *
     * @Route("/", name="estadisticas")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $req)
    {
        $dateFromTimestamp=$req->query->get('date-ini');
        $dateUntilTimestamp=$req->query->get('date-end');

        if (!$dateFromTimestamp)
        {
            $dateFromTimestamp= new \DateTime('- 1year');
            $dateFromTimestampString=$dateFromTimestamp->format('Y-m-d H:i:s');
        }else{
            $dateFromTimestamp= new \DateTime($dateFromTimestamp);
            $dateFromTimestampString=$dateFromTimestamp->format('Y-m-d H:i:s');
        }

        if (!$dateUntilTimestamp)
        {
            $dateUntilTimestamp= new \DateTime();
            $dateUntilTimestampString=$dateUntilTimestamp->format('Y-m-d H:i:s');
        }else{
            $dateUntilTimestamp= new \DateTime($dateUntilTimestamp);
            $dateUntilTimestampString=$dateUntilTimestamp->format('Y-m-d H:i:s');
        }

        $em = $this->getDoctrine();

        $paymentsByAccount = $em->getRepository('MGDBasicBundle:PaypalAccountsPayment')
            ->getRowsPaymentsToUsersByFecha($dateFromTimestampString,$dateUntilTimestampString);

        $expensesByAccount = $em->getRepository('MGDBasicBundle:PaypalAccountsPayment')
            ->getRowsExpensesToUsersByFecha($dateFromTimestampString,$dateUntilTimestampString);

        $expensesByAccountSum = $em->getRepository('MGDBasicBundle:PaypalAccountsPayment')
            ->getRowsSumPaymentsToUsersByFecha($dateFromTimestampString,$dateUntilTimestampString);

        $expensesCommon = $em->getRepository('MGDBasicBundle:PaypalAccountsPayment')
            ->getRowsExpensesByFecha($dateFromTimestampString,$dateUntilTimestampString);

        $pedidos = $em->getRepository('MGDBasicBundle:Pedido')
            ->getRowsPaymentsToUsersByMonth($dateFromTimestampString,$dateUntilTimestampString);


        return array(
            'dateFromTimestamp' => $dateFromTimestamp->format('Y-m-d'),
            'dateUntilTimestamp' => $dateUntilTimestamp->format('Y-m-d'),
            'paymentsByAccount' => $paymentsByAccount,
            'expensesByAccount' => $expensesByAccount,
            'expensesByAccountSum' => $expensesByAccountSum,

            'pedidos' => $pedidos,
            'expensesCommon' => $expensesCommon,
        );
    }

}
