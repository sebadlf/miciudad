<?php

namespace MiCiudad\ModeloBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MiCiudad\ModeloBundle\Entity\Dispositivo;
use MiCiudad\ModeloBundle\Form\DispositivoType;

/**
 * Dispositivo controller.
 *
 * @Route("/dispositivo")
 */
class DispositivoController extends Controller
{
    /**
     * Lists all Dispositivo entities.
     *
     * @Route("/", name="dispositivo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ModeloBundle:Dispositivo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Dispositivo entity.
     *
     * @Route("/{id}/show", name="dispositivo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ModeloBundle:Dispositivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dispositivo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Dispositivo entity.
     *
     * @Route("/new", name="dispositivo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Dispositivo();
        $form   = $this->createForm(new DispositivoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Dispositivo entity.
     *
     * @Route("/create", name="dispositivo_create")
     * @Method("POST")
     * @Template("ModeloBundle:Dispositivo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Dispositivo();
        $form = $this->createForm(new DispositivoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dispositivo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Dispositivo entity.
     *
     * @Route("/{id}/edit", name="dispositivo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ModeloBundle:Dispositivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dispositivo entity.');
        }

        $editForm = $this->createForm(new DispositivoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Dispositivo entity.
     *
     * @Route("/{id}/update", name="dispositivo_update")
     * @Method("POST")
     * @Template("ModeloBundle:Dispositivo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ModeloBundle:Dispositivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dispositivo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DispositivoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dispositivo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Dispositivo entity.
     *
     * @Route("/{id}/delete", name="dispositivo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ModeloBundle:Dispositivo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dispositivo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dispositivo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
