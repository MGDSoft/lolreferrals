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

use MGD\BasicBundle\Entity\ObjetoExtra;
use MGD\AdminBundle\Form\ObjetoExtraType;
use MGD\AdminBundle\Form\ObjetoExtraFilterType;

/**
 * ObjetoExtra controller.
 *
 * @Route("/objetoextra")
 */
class ObjetoExtraController extends Controller
{
    /**
     * Lists all ObjetoExtra entities.
     *
     * @Route("/", name="objetoextra")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

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
        $filterForm = $this->createForm(new ObjetoExtraFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('MGDBasicBundle:ObjetoExtra')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('ObjetoExtraControllerFilter');
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
                $session->set('ObjetoExtraControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('ObjetoExtraControllerFilter')) {
                $filterData = $session->get('ObjetoExtraControllerFilter');
                $filterForm = $this->createForm(new ObjetoExtraFilterType(), $filterData);
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
            return $me->generateUrl('objetoextra', array('page' => $page));
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
     * Creates a new ObjetoExtra entity.
     *
     * @Route("/", name="objetoextra_create")
     * @Method("POST")
     * @Template("AdminBundle:ObjetoExtra:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ObjetoExtra();
        $form = $this->createForm(new ObjetoExtraType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('objetoextra_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ObjetoExtra entity.
     *
     * @Route("/new", name="objetoextra_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ObjetoExtra();
        $form   = $this->createForm(new ObjetoExtraType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ObjetoExtra entity.
     *
     * @Route("/{id}", name="objetoextra_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:ObjetoExtra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ObjetoExtra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ObjetoExtra entity.
     *
     * @Route("/{id}/edit", name="objetoextra_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:ObjetoExtra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ObjetoExtra entity.');
        }

        $editForm = $this->createForm(new ObjetoExtraType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ObjetoExtra entity.
     *
     * @Route("/{id}", name="objetoextra_update")
     * @Method("PUT")
     * @Template("AdminBundle:ObjetoExtra:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:ObjetoExtra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ObjetoExtra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ObjetoExtraType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('objetoextra_edit', array('id' => $id)));
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
     * Deletes a ObjetoExtra entity.
     *
     * @Route("/{id}", name="objetoextra_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MGDBasicBundle:ObjetoExtra')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ObjetoExtra entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('objetoextra'));
    }

    /**
     * Creates a form to delete a ObjetoExtra entity by id.
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
