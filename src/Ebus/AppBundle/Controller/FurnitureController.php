<?php

namespace Ebus\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ebus\MyBundle\Entity\Furniture;
use Ebus\MyBundle\Form\FurnitureType;
use Ebus\MyBundle\Entity\Borrow;
use Ebus\MyBundle\Form\BorrowType;

/**
 * Furniture controller.
 *
 * @Route("/furniture")
 */
class FurnitureController extends Controller
{

    /**
     * Lists all Furniture entities.
     *
     * @Route("/", name="furniture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EbusMyBundle:Furniture')->findByActive(null);

        return array(
            'furnitures' => $entities,
            'user' => $this->getUser()
        );
    }

    /**
     * Lists all Furniture entities.
     *
     * @Route("/my", name="my_furniture")
     * @Method("GET")
     * @Template()
     */
    public function myIndexAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entities = $em->getRepository('EbusMyBundle:Furniture')->findBy(array('active' => null, 'user' => $user));

        return array(
            'furnitures' => $entities,
            'user' => $user
        );
    }
    
    /**
     * Creates a form to create a Borrow entity.
     *
     * @param Borrow $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBorrowForm(Borrow $entity)
    {
        $form = $this->createForm(new BorrowType(), $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Anfrage stellen'));

        return $form;
    }
    
    /**
     * Creates a new Furniture entity.
     *
     * @Route("/", name="furniture_create")
     * @Method("POST")
     * @Template("EbusAppBundle:Furniture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        $entity = new Furniture();
        $entity->setUser($user);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->upload();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('furniture_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Furniture entity.
     *
     * @param Furniture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Furniture $entity)
    {
        $form = $this->createForm(new FurnitureType(), $entity, array(
            'action' => $this->generateUrl('furniture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Furniture entity.
     *
     * @Route("/new", name="furniture_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Furniture();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Furniture entity.
     *
     * @Route("/{id}", name="furniture_show")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser(); 
        $borrow = new Borrow();

        $furniture = $em->getRepository('EbusMyBundle:Furniture')->find($id);
        $furnitureUser = $furniture->getUser();
        
        $borrow->setFurniture($furniture);
        $borrow->setLeaser($user);
        $borrow->setLessor($furnitureUser);
        $borrow->setDateFrom(new \DateTime('+1 day'));
        $borrow->setDateUntil(new \DateTime('+2 days'));
        $borrowForm = $this->createBorrowForm($borrow);

        if (!$furniture) {
            throw $this->createNotFoundException('Unable to find Furniture entity.');
        }
        $borrowForm->handleRequest($request);
        if ($borrowForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($borrow);
            $em->flush();

            return $this->redirect($this->generateUrl('borrow_detail_out', array('id' => $borrow->getId())));
        }

        return array(
            'entity'      => $furniture,
            'borrow' => $borrow,
            'borrow_form' => $borrowForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Furniture entity.
     *
     * @Route("/{id}/edit", name="furniture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entity = $em->getRepository('EbusMyBundle:Furniture')->findOneBy(array('id'=>$id, 'user'=>$user));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Furniture entity.');
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
    * Creates a form to edit a Furniture entity.
    *
    * @param Furniture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Furniture $entity)
    {
        $form = $this->createForm(new FurnitureType(), $entity, array(
            'action' => $this->generateUrl('furniture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualisieren'));

        return $form;
    }
    /**
     * Edits an existing Furniture entity.
     *
     * @Route("/{id}/edit", name="furniture_update")
     * @Method("PUT")
     * @Template("EbusMyBundle:Furniture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EbusMyBundle:Furniture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Furniture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();

            return $this->redirect($this->generateUrl('furniture_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Furniture entity.
     *
     * @Route("/{id}", name="furniture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EbusMyBundle:Furniture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Furniture entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('furniture'));
    }

    /**
     * Disable Deactivate Furniture
     *
     * @Route("/{id}/disable", name="disable_furniture")
     */
    public function disableAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EbusMyBundle:Furniture')->find($id);

        $entity->setActive(false);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('furniture'));
    }

    /**
     * Creates a form to delete a Furniture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('furniture_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
