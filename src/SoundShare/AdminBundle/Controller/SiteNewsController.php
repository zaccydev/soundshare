<?php

namespace SoundShare\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SoundShare\AdminBundle\Entity\SiteNews;
use SoundShare\AdminBundle\Form\SiteNewsType;

/**
 * SiteNews controller.
 *
 * @Route("/admin/sitenews")
 */
class SiteNewsController extends Controller
{

    /**
     * Lists all SiteNews entities.
     *
     * @Route("/", name="admin_sitenews")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SoundShareAdminBundle:SiteNews')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new SiteNews entity.
     *
     * @Route("/", name="admin_sitenews_create")
     * @Method("POST")
     * @Template("SoundShareAdminBundle:SiteNews:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SiteNews();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sitenews_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SiteNews entity.
     *
     * @param SiteNews $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SiteNews $entity)
    {
        $form = $this->createForm(new SiteNewsType(), $entity, array(
            'action' => $this->generateUrl('admin_sitenews_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SiteNews entity.
     *
     * @Route("/new", name="admin_sitenews_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SiteNews();
        $form = $this->createCreateForm($entity);

        /* return array(
          'entity' => $entity,
          'form'   => $form->createView(),
          ); */
        return $this->render('SoundShareAdminBundle:SiteNews:new.html.twig', array('form' => $form->createView(),));
    }

    /**
     * Finds and displays a SiteNews entity.
     *
     * @Route("/{id}", name="admin_sitenews_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SoundShareAdminBundle:SiteNews')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteNews entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SiteNews entity.
     *
     * @Route("/{id}/edit", name="admin_sitenews_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SoundShareAdminBundle:SiteNews')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteNews entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('SoundShareAdminBundle:SiteNews:edit.html.twig', array('edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView()));
        /* return array(
          'entity'      => $entity,
          'edit_form'   => $editForm->createView(),
          'delete_form' => $deleteForm->createView(),
          ); */
    }

    /**
     * Creates a form to edit a SiteNews entity.
     *
     * @param SiteNews $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SiteNews $entity)
    {
        $form = $this->createForm(new SiteNewsType(), $entity, array(
            'action' => $this->generateUrl('admin_sitenews_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing SiteNews entity.
     *
     * @Route("/{id}", name="admin_sitenews_update")
     * @Method("PUT")
     * @Template("SoundShareAdminBundle:SiteNews:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SoundShareAdminBundle:SiteNews')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteNews entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sitenews_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SiteNews entity.
     *
     * @Route("/{id}", name="admin_sitenews_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SoundShareAdminBundle:SiteNews')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SiteNews entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_sitenews'));
    }

    /**
     * Creates a form to delete a SiteNews entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_sitenews_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
