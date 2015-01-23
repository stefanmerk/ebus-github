<?php

namespace Ebus\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/add")
     */
    public function indexAction() {
        /*$user = new \Ebus\MyBundle\Entity\User();
        
        $user->setActive(true);
        $user->setEmail('hans@wurst.com');
        $user->setFirstName('Hans');
        $user->setGps('40.67751363;-73.92906189');
        $user->setLastName('Wurst');
        $user->setPassword('password');
        $user->setStreet('WeidachStraße');
        $user->setStreetNumber('12');
        $user->setTown('Karlsruhe');
        $user->setZip('76131');*/
        
        /*$category = new \Ebus\MyBundle\Entity\Category();
        $category->setActive(true);
        $category->setName('Komplett-Set');*/
        
        /*$condition = new \Ebus\MyBundle\Entity\Condition();
        $condition->setActive(true);
        $condition->setName('Schlecht');*/
        
        
        /*$fCategory = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Category')
                ->find(1);
        $fCondition = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Condition')
                ->find(1);
        $fUser = $this->getDoctrine()
                ->getRepository('EbusMyBundle:User')
                ->find(1);
        
        $furniture = new \Ebus\MyBundle\Entity\Furniture();
        $furniture->setActive(true);
        $furniture->setCategory($fCategory);
        $furniture->setCondition($fCondition);
        $furniture->setDescription('Herzensbrechnender Schrank mit viel Funktionen: Regalen, Kleiderhaken und viel mehr');
        $furniture->setImage('fertert.jpg');
        $furniture->setName('H-H-H-HEARTBREAKER');
        $furniture->setPrice(19.99);
        $furniture->setUser($fUser);*/
        
        /*$rUser = $this->getDoctrine()
                ->getRepository('EbusMyBundle:User')
                ->find(1);
        
        $rFurniture = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Furniture')
                ->find(1);
        
        $rating = new \Ebus\MyBundle\Entity\Rating();
        $rating->setActive(true);
        $rating->setComment('Wont start After upgraded my S5 to Android 5.0 ,facebook app crashes every time i turn it on, pls fix this');
        $rating->setFurniture($rFurniture);
        $rating->setStars(4);
        $rating->setUser($rUser);
        */
        
        
        /*$bUser1 = $this->getDoctrine()
                ->getRepository('EbusMyBundle:User')
                ->find(1);
        
        $bUser2 = $this->getDoctrine()
                ->getRepository('EbusMyBundle:User')
                ->find(2);
        
        $bFurniture = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Furniture')
                ->find(1);
        
        $borrow = new \Ebus\MyBundle\Entity\Borrow();
        $borrow->setDateFrom(new \DateTime('+1 week'));
        $borrow->setDateUntil(new \DateTime('+3 week'));
        $borrow->setFurniture($bFurniture);
        $borrow->setLeaser($bUser2);
        $borrow->setLessor($bUser1);
        $borrow->setPrice(198.98);*/
        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($borrow);
        $em->flush();
        
        
        return new \Symfony\Component\HttpFoundation\Response('Haha');
    }
    
    /**
     * @Route("/rest/furniture")
     * @Method({"GET"})
     */
    public function moebelGetAction()
    {
        $jms = $this->container->get('jms_serializer');
        
        $furnitures = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Furniture')
                ->findAll();
        
        $json = $jms->serialize($furnitures, 'json');
        
        
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("/rest/furniture/{id}")
     * @Method({"GET"})
     */
    public function moebelOneGetAction($id) {
        $jms = $this->container->get('jms_serializer');
        
        $furnitures = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Furniture')
                ->find($id);
        
        $json = $jms->serialize($furnitures, 'json');
        
        
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    /**
     * @Route("/rest/inrequests")
     * GET OPEN REQUESTS
     */
    public function moebelRequestsAction() {
        $jms = $this->container->get('jms_serializer');
        
        $furnitures = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Borrow')
                ->findBy(array('accepted' => null));
        
        $json = $jms->serialize($furnitures, 'json');
        
        
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("/rest/furniture/add")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function moebelAddAction(Request $request) {
        $jms = $this->container->get('jms_serializer');
        $form = json_decode($request->getContent());
        
        $fCategory = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Category')
                ->find($form->{'category'});
        $fCondition = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Condition')
                ->find($form->{'condition'});
        $fUser = $this->getDoctrine()
                ->getRepository('EbusMyBundle:User')
                ->find(1);
        
        $furniture = new \Ebus\MyBundle\Entity\Furniture();
        $furniture->setActive(true);
        $furniture->setCategory($fCategory);
        $furniture->setCondition($fCondition);
        $furniture->setDescription($form->{'description'});
        $furniture->setImage('fertert.jpg');
        $furniture->setName($form->{'name'});
        $furniture->setPrice($form->{'price'});
        $furniture->setUser($fUser);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($furniture);
        $em->flush();
        
        $response = new Response();
        $response->setContent($jms->serialize($furniture, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("/rest/inrequests/accept/{id}")
     */
    public function moebelRequestAcceptAction($id) {
        $jms = $this->container->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        
        $borrow = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Borrow')
                ->find($id);
        
        $borrow->setAccepted(true);
        
        $em->persist($borrow);
        $em->flush();
        
        $json = $jms->serialize($borrow, 'json');
        
        
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    
    /**
     * @Route("/rest/inrequests/reject/{id}")
     */
    public function moebelRequestRejectAction($id) {
        $jms = $this->container->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        
        $borrow = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Borrow')
                ->find($id);
        
        $borrow->setAccepted(false);
        
        $em->persist($borrow);
        $em->flush();
        
        $json = $jms->serialize($borrow, 'json');
        
        
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("/rest/categories")
     */
    public function categoriesAction() {
        $jms = $this->container->get('jms_serializer');
        
        $categories = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Category')
                ->findAll();
        
        $json = $jms->serialize($categories, 'json');
        
        
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("/rest/conditions")
     */
    public function conditionsAction() {
        $jms = $this->container->get('jms_serializer');
        
        $conditions = $this->getDoctrine()
                ->getRepository('EbusMyBundle:Condition')
                ->findAll();
        
        $json = $jms->serialize($conditions, 'json');
        
        
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
