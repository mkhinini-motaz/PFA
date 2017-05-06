<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\Entity\Abonne;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction()
    {

        return $this->render('admin/index.html.twig');

    }

    /**
     * @Route("/users", name="admin_users")
     */
    public function usersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $abonnes = $em->getRepository('AppBundle:Abonne')->findAllJoined();

        return $this->render('admin/users.html.twig', ['abonnes' => $abonnes]);
    }

    /**
     * @Route("/bannir/{id}", name="bannir_abonne")
     */
    public function bannirAction(Abonne $abonne)
    {

    	$abonne->getCompte()->setEnabled(false);

    	$em = $this->getDoctrine()->getManager();
        $em->persist($abonne);
        $em->flush();

    	return $this->render('admin/delete.html.twig',  array("abonne" => $abonne));
    }

    /**
     * @Route("/activate/{id}", name="activate_abonne")
     */
    public function activateAction(Abonne $abonne)
    {

        $abonne->getCompte()->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($abonne);
        $em->flush();

    	return $this->render('admin/activate.html.twig',  array("abonne" => $abonne));
    }

}
