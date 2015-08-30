<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Record;
use AppBundle\Entity\Project;
use AppBundle\Form\RecordType;

/**
 * Record controller.
 *
 */
class RecordController extends Controller
{

    /**
     * Lists all Record entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Record')->findAll();

        return $this->render('AppBundle:Record:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Record entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Record();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Set user
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('records_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Record:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Record entity.
     *
     * @param Record $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Record $entity)
    {
        $form = $this->createForm(new RecordType(), $entity, array(
            'action' => $this->generateUrl('records_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Record entity.
     *
     */
    public function newAction()
    {
        $entity = new Record();
        $form   = $this->createCreateForm($entity);
        return $this->render('AppBundle:Record:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Record entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Record')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Record entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Record:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Record entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Record')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Record entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Record:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Record entity.
    *
    * @param Record $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Record $entity)
    {
        $form = $this->createForm(new RecordType(), $entity, array(
            'action' => $this->generateUrl('records_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Record entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Record')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Record entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('records_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Record:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Record entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Record')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Record entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('records'));
    }

    /**
     * Creates a form to delete a Record entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('records_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    /**
     * Lists all Record entities.
     *
     */
    public function blockLastAction($max = 5, Project $project = NULL)
    {
        $em = $this->getDoctrine()->getManager();

        if ($project) {
          if ($max) {
            $entities = $em->getRepository('AppBundle:Record')->findByProject($project, array('id' => 'DESC'), $max);
          }
          else {
            $entities = $em->getRepository('AppBundle:Record')->findByProject($project, array('id' => 'DESC'));
          }
        }
        else {
          if ($max) {
            $entities = $em->getRepository('AppBundle:Record')->findBy(array(), array('id' => 'DESC'), $max);
          }
          else {
            $entities = $em->getRepository('AppBundle:Record')->findBy(array(), array('id' => 'DESC'));
          }
        }

        return $this->render('AppBundle:Record:block/list.html.twig', array(
            'entities' => $entities,
        ));
    }
}
