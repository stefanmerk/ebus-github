<?php

namespace Ebus\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ebus\MyBundle\Entity\Furniture;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if(!$user->hasAddress())
            return $this->redirect ($this->generateUrl('fos_user_profile_edit'));
        
        return array('name' => '');
    }
    
    /**
     * @Route("/inrequest", name="borrows")
     * @Template()
     */
    public function borrowsAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entities = $em->getRepository('EbusMyBundle:Borrow')->findBy(array('lessor' => $user, 'accepted' => null));

        return array(
            'borrows' => $entities,
        );
    }
    
    /**
     * @Route("/inrequest/{id}", name="borrow_detail")
     * @Template()
     */
    public function borrowDetailAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        $entity = $em->getRepository('EbusMyBundle:Borrow')->findOneBy(array('lessor' => $user, 'id' => $id));
        
        return array(
            'borrow' => $entity,
        );
    }
    
    /**
     * @Route("/outrequest/{id}", name="borrow_detail_out")
     * @Template()
     */
    public function borrowDetailOutAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        $entity = $em->getRepository('EbusMyBundle:Borrow')->findOneBy(array('leaser' => $user, 'id' => $id));
        
        return array(
            'borrow' => $entity,
        );
    }
    
    
    /**
     * @Route("/inrequest/{id}/{type}", name="borrow_detail_accept_reject")
     * @Template()
     */
    public function acceptRejectAction($id, $type) {
        if($type == "accept") {
            $accRej = true;
        } elseif($type=="reject") {
            $accRej = false;
        } else {
            return;
        }
        
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        $borrow = $em->getRepository('EbusMyBundle:Borrow')->findOneBy(array('lessor' => $user, 'id' => $id));
        
        $borrow->setAccepted($accRej);
        
        $em->persist($borrow);
        $em->flush();
        
        return $this->redirect($this->generateUrl('borrows'));
    }
    
    /**
     * @Route("/furnitures")
     * @Template()
     */
    public function furnitureAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $furnitures = $this->getDoctrine()->getRepository('EbusMyBundle:Furniture')->findAll();
        
        return array('furnitures' => $furnitures);
    }
}
