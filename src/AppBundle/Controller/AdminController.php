<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Ob\HighchartsBundle\Highcharts\Highchart;

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

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Event');
        $event = $repo->find(1);
        var_dump($event->getVues()->get(2)->getDateVue()->format('y-m-d W'));



        return $this->render('admin/index.html.twig');

    }

}
