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
 * @Route("/vermieten")
 */
class VermieteteMoebelController extends Controller
{
    /**
     * @Route("/", name="vermietete")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entities = $em->getRepository('EbusMyBundle:Borrow')->findBy(array('lessor' => $user, 'accepted' => true));

        return array(
            'borrows' => $entities,
        );
    }
    
    /**
     * @Route("/{id}", name="vermietete_details")
     * @Template()
     */
    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entity = $em->getRepository('EbusMyBundle:Borrow')->findOneBy(array('lessor' => $user, 'id' => $id, 'accepted' => true));

        return array(
            'borrow' => $entity,
        );
    }
}