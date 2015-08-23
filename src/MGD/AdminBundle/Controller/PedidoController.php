<?php

namespace MGD\AdminBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Estado;
use MGD\BasicBundle\Entity\EXT\EXTRefseu;
use MGD\BasicBundle\Entity\PedidoBots;
use MGD\BasicBundle\Service\PedidoPagoService;
use MGD\BasicBundle\Service\PedidoService;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
use MGD\AdminBundle\Form\PedidoType;
use MGD\AdminBundle\Form\PedidoFilterType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Pedido controller.
 *
 *
 * @Route("/pedido")
 */
class PedidoController extends Controller
{
    /**
     * @var PedidoService
     *
     * @DI\Inject
     */
    protected $pedidoService;

    /**
     * Lists all Pedido entities.
     *
     * @Route("/", name="pedido")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        /** @var \Doctrine\ORM\QueryBuilder $queryBuilder */

        $queryBuilder->andWhere('e.estado is not null')->orderBy('e.fecha', 'DESC');

        /** @var Pedido[] $entities */
        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        foreach ($entities as $entity)
        {
            $this->pedidoService->setQueueDaysRemaining($entity);
        }

        return array(
            'entities'   => $entities,
            'pagerHtml'  => $pagerHtml,
            'filterForm' => $filterForm->createView()
        );
    }

    /**
     * Lists all Pedido entities.
     *
     * @Route("/completado/{id}", name="pedido_completado")
     * @ParamConverter("pedido", class="MGDBasicBundle:Pedido", options={"id" = "id"})
     * @Method("GET")
     */
    public function completadoAction(Pedido $pedido)
    {
        $em = $this->getDoctrine()->getManager();
        $pedido->setEstado($em->getRepository("MGDBasicBundle:Estado")->find(EstadoEnum::Finalizado));

        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

        return $this->redirect($this->generateUrl('pedido'));
    }

    /**
     * Create filter form and process filter request.
     *
     */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new PedidoFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('MGDBasicBundle:Pedido')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PedidoControllerFilter');
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
                $session->set('PedidoControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PedidoControllerFilter')) {
                $filterData = $session->get('PedidoControllerFilter');
                try {
                    $filterForm = $this->createForm(new PedidoFilterType(), $filterData);
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
            return $me->generateUrl('pedido', array('page' => $page));
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
     * Creates a new Pedido entity.
     *
     * @Route("/", name="pedido_create")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Method("POST")
     * @Template("MGDAdminBundle:Pedido:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pedido();
        $form = $this->createForm(new PedidoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('pedido_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Pedido entity.
     *
     * @Route("/new", name="pedido_new")
     * @Method("GET")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pedido();
        $form = $this->createForm(new PedidoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pedido entity.
     *
     * @Route("/{id}", name="pedido_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        /* @var Pedido $entity */

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pedido entity.
     *
     * @Route("/{id}/edit", name="pedido_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $editForm = $this->createForm(new PedidoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Pedido entity.
     *
     * @Route("/{id}", name="pedido_update")
     * @Method("PUT")
     * @Template("MGDAdminBundle:Pedido:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PedidoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $this->insertarBots($editForm, $entity, $em);

            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('pedido_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        /* @var Pedido $entity */

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * @param $editForm
     * @param Pedido $pedido
     * @param ObjectManager $em
     */
    private function insertarBots($editForm, Pedido $pedido, $em)
    {
        /** @var Form $file */
        $file = $editForm['bots'];
        if ($file->getViewData()) {
            /** @var PedidoBots[] $bots */
            $bots = $em->getRepository('MGDBasicBundle:PedidoBots')->findByPedido($pedido->getId());
            /** @var EXTRefseu[] $botsExt */
            $botsExt = $em->getRepository('MGDBasicBundle:EXT\EXTRefseu')->findByREFID($pedido->getId());

            $dir = sys_get_temp_dir();
            $fileName = date("Y-m-d_H-i-s") . ".txt";
            $file->getData()->move($dir, $fileName);

            $file = file($dir . DIRECTORY_SEPARATOR . $fileName);
            foreach ($file as $line) {
                $arr = explode(":", trim($line));
                if (isset($arr[0]) && isset($arr[1])) {
                    $flag = false;
                    $nombreBot = $arr[0];
                    $passwordBot = $arr[1];
                    /** @var ArrayCollection $bots */
                    foreach ($bots as $key => $bot) {
                        if ($bot->getNombre() == $nombreBot) {
                            $flag = true;
                            unset($bots[$key]);
                            break;
                        }
                    }

                    foreach ($botsExt as $key => $bot) {
                        if ($bot->getUsername() == $nombreBot) {
                            unset($botsExt[$key]);
                            break;
                        }
                    }

                    if ($flag) {
                        continue;
                    }

                    $pedidoBots = new PedidoBots();

                    $pedidoBots->setNombre($nombreBot);
                    $pedidoBots->setContrasena($passwordBot);
                    $pedidoBots->setPedido($pedido);

                    $em->persist($pedidoBots);

                    $em->flush();

                    $ref = new EXTRefseu($pedidoBots);
                    $em->persist($ref);
                    $em->flush();

                }
            }

            foreach ($bots as $bot) {
                $em->remove($bot);
            }

            foreach ($botsExt as $bot) {
                $em->remove($bot);
            }

        }

        $em->flush();
    }

    /**
     * Deletes a Pedido entity.
     *
     * @Route("/{id}", name="pedido_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MGDBasicBundle:Pedido')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pedido entity.');
            }

            $em->remove($entity);

            $botsExt = $em->getRepository('MGDBasicBundle:EXT\EXTRefseu')->findByREFID($entity->getId());
            foreach ($botsExt as $bot) {
                $em->remove($bot);
            }

            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('pedido'));
    }

    /**
     * Deletes a PedidoEstados entity.
     *
     * @Route("/{id}/{lvl}", name="pedido_update_bots")
     * @ParamConverter("id", class="MGDBasicBundle:Pedido", options={"id" = "id"})
     * @Method("GET")
     */
    public function updateBotsAction(Pedido $pedido, $lvl)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('MGDBasicBundle:PedidoBots')->updateAllLvlsByPedido($pedido->getId(), $lvl);

        if ($pedido->getEstado()->getId() != EstadoEnum::Finalizado && $lvl == 10) {
            $estadoFinalizado = $em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Finalizado);

            $pedido->setEstado($estadoFinalizado);

            $em->persist($pedido);

            $em->flush();

        } else if ($pedido->getEstado()->getId() == EstadoEnum::Finalizado && $lvl != 10) {

            $estadoCola = $em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);
            $pedido->setEstado($estadoCola);

            $em->persist($pedido);

            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

        return $this->redirect($this->generateUrl('pedido_edit', array('id' => $pedido->getId())));
    }

    /**
     * Creates a form to delete a Pedido entity by id.
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
