<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\Client;
use AppBundle\Form\ProjectType;

/**
 * Project controller.
 *
 */
class ProjectController extends Controller
{

    /**
     * Lists all Project entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Project')->findAll();

        return $this->render('AppBundle:Project:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Project entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Project();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'message',
                array(
                    'alert' => 'success',
                    'message' => 'The project has been successfully created.',
                )
            );

            return $this->redirect($this->generateUrl('projects_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Project:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, array(
            'action' => $this->generateUrl('projects_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Project entity.
     *
     */
    public function newAction()
    {
        $entity = new Project();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Project:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Project entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $converter = $this->get('app.dconverter');
        $timesPerUser = $em->getRepository('AppBundle:Project')->getTotalHoursByUser($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Project:show.html.twig', array(
            'entity'        => $entity,
            'delete_form'   => $deleteForm->createView(),
            'times_per_user' => $timesPerUser,
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Project:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Project entity.
    *
    * @param Project $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, array(
            'action' => $this->generateUrl('projects_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Project entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'message',
                array(
                    'alert' => 'success',
                    'message' => 'The project has been successfully updated.',
                )
            );

            return $this->redirect($this->generateUrl('projects_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Project:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Project entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Project')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Project entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'message',
                array(
                    'alert' => 'success',
                    'message' => 'The project has been successfully removed.',
                )
            );
        }

        return $this->redirect($this->generateUrl('projects'));
    }

    /**
     * Creates a form to delete a Project entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('projects_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Lists all Project entities.
     *
     */
    public function blockIndexAction(Client $client = NULL)
    {
        $em = $this->getDoctrine()->getManager();

        if ($client) {
          $entities = $em->getRepository('AppBundle:Project')->findByClient($client);
        }
        else {
          $entities = $em->getRepository('AppBundle:Project')->findAll();
        }

        return $this->render('AppBundle:Project:block/list.html.twig', array(
            'entities' => $entities,
        ));
    }
}
