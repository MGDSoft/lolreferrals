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

use MGD\BasicBundle\Entity\Articulo;
use MGD\AdminBundle\Form\ArticuloType;
use MGD\AdminBundle\Form\ArticuloFilterType;

/**
 * Articulo controller.
 *
 * @Route("/articulo")
 */
class ArticuloController extends Controller
{
    /**
     * Lists all Articulo entities.
     *
     * @Route("/", name="articulo")
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
        $filterForm = $this->createForm(new ArticuloFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('MGDBasicBundle:Articulo')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('ArticuloControllerFilter');
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
                $session->set('ArticuloControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('ArticuloControllerFilter')) {
                $filterData = $session->get('ArticuloControllerFilter');
                $filterForm = $this->createForm(new ArticuloFilterType(), $filterData);
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
            return $me->generateUrl('articulo', array('page' => $page));
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
     * Creates a new Articulo entity.
     *
     * @Route("/", name="articulo_create")
     * @Method("POST")
     * @Template("MGDAdminBundle:Articulo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Articulo();
        $form = $this->createForm(new ArticuloType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

	        $redirectsPostPaypal='
			    <input type="hidden" name="return" value="'.$this->generateUrl('home').'">
				<input type="hidden" name="cancel_return" value="'.$this->generateUrl('home').'">
				<input type="hidden" name="notify_url " value="'.$this->generateUrl('pago_completado').'">
				<input type="hidden" name="ipn_notify_url" value="'.$this->generateUrl('pago_completado').'" />
				</form>
			';

	        $entity->setPaypalHtml(
		        str_replace('</form>',$redirectsPostPaypal,$entity->getPaypalHtml())
	        );

            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Articulo entity.
     *
     * @Route("/new", name="articulo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Articulo();
        $form   = $this->createForm(new ArticuloType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Articulo entity.
     *
     * @Route("/{id}", name="articulo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Articulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Articulo entity.
     *
     * @Route("/{id}/edit", name="articulo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Articulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }

        $editForm = $this->createForm(new ArticuloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Articulo entity.
     *
     * @Route("/{id}", name="articulo_update")
     * @Method("PUT")
     * @Template("MGDAdminBundle:Articulo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Articulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ArticuloType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('articulo_edit', array('id' => $id)));
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
     * Deletes a Articulo entity.
     *
     * @Route("/{id}", name="articulo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MGDBasicBundle:Articulo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Articulo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('articulo'));
    }

    /**
     * Creates a form to delete a Articulo entity by id.
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
