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

use MGD\BasicBundle\Entity\PedidoEstados;
use MGD\AdminBundle\Form\PedidoEstadosType;
use MGD\AdminBundle\Form\PedidoEstadosFilterType;

/**
 * PedidoEstados controller.
 *
 * @Route("/pedidoestados")
 */
class PedidoEstadosController extends Controller
{
    /**
     * Lists all PedidoEstados entities.
     *
     * @Route("/", name="pedidoestados")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        $queryBuilder->orderBy('e.fecha', 'DESC');

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        return array(
            'entities'   => $entities,
            'pagerHtml'  => $pagerHtml,
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
        $filterForm = $this->createForm(new PedidoEstadosFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('MGDBasicBundle:PedidoEstados')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PedidoEstadosControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('PedidoEstadosControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PedidoEstadosControllerFilter')) {
                $filterData = $session->get('PedidoEstadosControllerFilter');
                try {
                    $filterForm = $this->createForm(new PedidoEstadosFilterType(), $filterData);
                } catch (\Exception $e) {
                    // empty values
                    return array($filterForm, $queryBuilder);
                }
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
        $routeGenerator = function ($page) use ($me) {
            return $me->generateUrl('pedidoestados', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render(
            $pagerfanta,
            $routeGenerator,
            array(
                'proximity'    => 3,
                'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
                'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
            )
        );

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new PedidoEstados entity.
     *
     * @Route("/", name="pedidoestados_create")
     * @Method("POST")
     * @Template("MGDAdminBundle:PedidoEstados:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PedidoEstados();
        $form = $this->createForm(new PedidoEstadosType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $pedido = $entity->getPedido();
            $pedido->setEstado($entity->getEstado());
            $em->persist($pedido);

            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('pedidoestados'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new PedidoEstados entity.
     *
     * @Route("/new", name="pedidoestados_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PedidoEstados();
        $form = $this->createForm(new PedidoEstadosType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PedidoEstados entity.
     *
     * @Route("/{id}", name="pedidoestados_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:PedidoEstados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoEstados entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PedidoEstados entity.
     *
     * @Route("/{id}/edit", name="pedidoestados_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:PedidoEstados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoEstados entity.');
        }

        $editForm = $this->createForm(new PedidoEstadosType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing PedidoEstados entity.
     *
     * @Route("/{id}", name="pedidoestados_update")
     * @Method("PUT")
     * @Template("MGDAdminBundle:PedidoEstados:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:PedidoEstados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoEstados entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PedidoEstadosType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('pedidoestados_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a PedidoEstados entity.
     *
     * @Route("/{id}", name="pedidoestados_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MGDBasicBundle:PedidoEstados')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PedidoEstados entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('pedidoestados'));
    }

    /**
     * Creates a form to delete a PedidoEstados entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))->add('id', 'hidden')->getForm();
    }
}
