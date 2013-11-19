<?php

namespace MGD\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MGD\BasicBundle\Entity\Cola;
use MGD\AdminBundle\Form\ColaType;

/**
 * Cola controller.
 *
 * @Route("/cola")
 */
class ColaController extends Controller
{


    /**
     * Displays a form to edit an existing Cola entity.
     *
     * @Route("/{id}/edit", name="cola_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Cola')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cola entity.');
        }

        $editForm = $this->createForm(new ColaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Cola entity.
     *
     * @Route("/{id}", name="cola_update")
     * @Method("PUT")
     * @Template("MGDAdminBundle:Cola:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MGDBasicBundle:Cola')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cola entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ColaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cola_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
