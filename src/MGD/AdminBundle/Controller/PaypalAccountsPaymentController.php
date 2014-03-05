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
 * @Route("/paypalaccountspayments")
 */
class PaypalAccountsPaymentController extends Controller
{
    /**
     * Lists all PaypalAccountsPayment entities.
     *
     * @Route("/", name="paypalaccountspayments")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        $queryBuilder->orderBy('e.fecha','DESC');

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new PaypalAccountsPaymentFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('MGDBasicBundle:PaypalAccountsPayment')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('PaypalAccountsPaymentControllerFilter');
        }

        // Filter action
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('PaypalAccountsPaymentControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PaypalAccountsPaymentControllerFilter')) {
                $filterData = $session->get('PaypalAccountsPaymentControllerFilter');
                $filterForm = $this->createForm(new PaypalAccountsPaymentFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder)
    {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me)
        {
            return $me->generateUrl('paypalaccountspayments', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new PaypalAccountsPayment entity.
     *
     * @Route("/", name="paypalaccountspayments_create")
     * @Method("POST")
     * @Template("MGDAdminBundle:PaypalAccountsPayment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new PaypalAccountsPayment();
        $form = $this->createForm(new PaypalAccountsPaymentType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('paypalaccountspayments_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new PaypalAccountsPayment entity.
     *
     * @Route("/new", name="paypalaccountspayments_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PaypalAccountsPayment();
        $form   = $this->createForm(new PaypalAccountsPaymentType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PaypalAccountsPayment entity.
     *
     * @Route("/{id}", name="paypalaccountspayments_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:PaypalAccountsPayment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PaypalAccountsPayment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to delete a PaypalAccountsPayment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
