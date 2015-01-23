<?php

namespace Ebus\MyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ebus\MyBundle\Entity\Borrow;
use Ebus\MyBundle\Form\BorrowType;

/**
 * Borrow controller.
 *
 * @Route("/x/borrow")
 */
class BorrowController extends Controller
{

    /**
     * Lists all Borrow entities.
     *
     * @Route("/", name="borrow")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entities = $em->getRepository('EbusMyBundle:Borrow')->findBy(array('lessor' => $user, 'accepted' => null));

        return array(
            'entities' => $entities,
        );
    }
    
    private function createAcceptRefuseForm(Borrow $borrow) {
        $form = $this->createForm($type);
    }
    /**
     * Creates a new Borrow entity.
     *
     * @Route("/{id}", name="borrow_create")
     * @Method("POST")
     * @Template("EbusMyBundle:Borrow:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser(); 
        $borrow = new Borrow();
        
        $furniture = $em->getRepository('EbusMyBundle:Furniture')->find($id);
        $furnitureUser = $furniture->getUser();
        
        $borrow->setFurniture($furniture);
        $borrow->setLeaser($user);
        $borrow->setLessor($furnitureUser);
        
        $form = $this->createCreateForm($borrow);
        
        $form->handleRequest($request);
        if (!$furniture) {
            throw $this->createNotFoundException('Unable to find Furniture entity.');
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($borrow);
            $em->flush();

            return $this->redirect($this->generateUrl('borrow_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $borrow,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Borrow entity.
     *
     * @param Borrow $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Borrow $entity)
    {
        $form = $this->createForm(new BorrowType(), $entity, array(
            'action' => $this->generateUrl('borrow_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Borrow entity.
     *
     * @Route("/new", name="borrow_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Borrow();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Borrow entity.
     *
     * @Route("/{id}", name="borrow_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EbusMyBundle:Borrow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Borrow entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Borrow entity.
     *
     * @Route("/{id}/edit", name="borrow_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EbusMyBundle:Borrow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Borrow entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Borrow entity.
    *
    * @param Borrow $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Borrow $entity)
    {
        $form = $this->createForm(new BorrowType(), $entity, array(
            'action' => $this->generateUrl('borrow_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Borrow entity.
     *
     * @Route("/{id}", name="borrow_update")
     * @Method("PUT")
     * @Template("EbusMyBundle:Borrow:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EbusMyBundle:Borrow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Borrow entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('borrow_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Borrow entity.
     *
     * @Route("/{id}", name="borrow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EbusMyBundle:Borrow')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Borrow entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('borrow'));
    }

    /**
     * Creates a form to delete a Borrow entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('borrow_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
