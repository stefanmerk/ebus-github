<?php

namespace Ebus\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Ebus\MyBundle\Entity\Furniture;
use Ebus\MyBundle\Entity\Borrow;
use Ebus\MyBundle\Entity\Rating;
use Ebus\MyBundle\Form\RatingType;

/**
 * 
 * @Route("/mieten")
 */
class GemieteteMoebelController extends Controller
{
    /**
     * @Route("/", name="mieten")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entities = $em->getRepository('EbusMyBundle:Borrow')->findBy(array('leaser' => $user, 'accepted' => true));

        return array(
            'borrows' => $entities,
        );
    }
    
    /**
     * @Route("/{id}", name="gemietete_details")
     * @Template()
     */
    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entity = $em->getRepository('EbusMyBundle:Borrow')->findOneBy(array('leaser' => $user, 'id' => $id, 'accepted' => true));

        return array(
            'borrow' => $entity,
        );
    }
    
    /**
     * @Route("/{id}/bewerten", name="gemietete_bewerten")
     * @Template()
     */
    public function bewertenAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        $entity = $em->getRepository('EbusMyBundle:Borrow')->findOneBy(array('leaser' => $user, 'id' => $id, 'accepted' => true));
        $furniture = $entity->getFurniture();

        $rating = new Rating();
        $rating->setUser($user);
        $rating->setFurniture($furniture);
        $form   = $this->createBewertenForm($rating);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();
            
            return $this->redirect($this->generateUrl('furniture_show', array('id' => $furniture->getId())));
        }
        
        return array(
            'borrow' => $entity,
            'form_bewerten' => $form->createView(),
        );
        
        
        
        
//        $entity = new Furniture();
//        $form = $this->createCreateForm($entity);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('furniture_show', array('id' => $entity->getId())));
//        }
//
//        return array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        );
    }
    
    /**
     * Creates a form to create a Borrow entity.
     *
     * @param Borrow $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBewertenForm(Rating $bewertung)
    {
        $form = $this->createForm(new RatingType(), $bewertung, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Bewerten'));

        return $form;
    }
    
}
