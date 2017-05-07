<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Doctrine\ORM\Query\ResultSetMapping;
use AppBundle\Entity\Abonne;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    private $em;
    private $mois;
    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $this->mois = $this->initialiseMois();
        $obVue = $this->createVueChart();

        $obReservations = $this->createReservationsChart();

        $obEvent = $this->createEventChart();

        return $this->render('admin/index.html.twig', [
                                                       'chartReservation' => $obReservations
                                                      ,'chartVue' => $obVue
                                                      ,'chartPublication' => $obEvent["publication"]
                                                      ,'chartRealisation' => $obEvent["realisation"]
                                                      ]
        );

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


/**************************** Méthodes de création des charts **************************************/
/***************************************************************************************************/

    public function createVueChart()
    {
        $data = array();
        $vues = $this->em->getRepository('AppBundle:Vue')->findAll();

        foreach ($vues as $vue) {
            $week = $vue->getDateVue()->format('W');
            $ancienValeur = isset($data[$week]) ? $data[$week] : 0;
            $data[$week] = $ancienValeur + 1;
        }

        $data2 = array();
        foreach ($data as $key => $value) {
            $data2[] = [intval($key), $value];
        }

        usort($data2, function($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });

        // Chart
        $series = array(
            array("name" => "Intéressement",    "data" => $data2)
        );

        $obVue = new Highchart();
        $obVue->chart->renderTo('linechartVue');  // The #id of the div where to render the chart
        $obVue->title->text('Nombre des interessées par semaine de l\'année sur le site');
        $obVue->xAxis->title(array('text'  => "Semaine"));
        $obVue->xAxis->allowDecimals(false);
        $obVue->yAxis->allowDecimals(false);
        $obVue->yAxis->title(array('text'  => "Nombre des interessées"));
        $obVue->series($series);
        $obVue->xAxis->categories($this->mois);
        return $obVue;
    }

/***************************************************************************************************/

    public function createReservationsChart()
    {
        $reservations = $this->em->getRepository('AppBundle:Reservation')->findAll();
        $data = array();
        foreach ($reservations as $reservation) {
            $week = $reservation->getDateReservation()->format('W');
            $ancienValeur = isset($data[$week]) ? $data[$week] : 0;
            $data[$week] = $ancienValeur + $reservation->getNbrPlaces();
        }

        $data2 = array();
        foreach ($data as $key => $value) {
            $data2[] = [intval($key), $value];
        }
        usort($data2, function($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });

        // Chart
        $series = array(
            array("name" => "Reservations",    "data" => $data2)
        );

        $obReservations = new Highchart();
        $obReservations->chart->renderTo('linechartReservation');  // The #id of the div where to render the chart
        $obReservations->title->text('Nombre de places reservé par semaine de l\'année sur le site');
        $obReservations->xAxis->title(array('text'  => "Semaine"));
        $obReservations->xAxis->allowDecimals(false);
        $obReservations->yAxis->allowDecimals(false);
        $obReservations->yAxis->title(array('text'  => "Nombre de places réservé"));
        $obReservations->series($series);
        $obReservations->xAxis->categories($this->mois);
        return $obReservations;
    }

/********************************************************************************************************/

    public function createEventChart()
    {
        /******* Courbe statistique des events ******************************************************/
        $events = $this->em->getRepository('AppBundle:Event')->findAll();
        $datePublication = array();
        $dates = array();
        foreach ($events as $event) {
            /* Récupération de nombre d'events selon semaine de publication*/
            $week = $event->getDatePublication()->format('W');
            $ancienValeur = isset($datePublication[$week]) ? $datePublication[$week] : 0;
            $datePublication[$week] = $ancienValeur + 1;

            /* Récupération de nombre d'events selon semaine de réalisation*/
            $week = $event->getDateFin()->format('W');
            $ancienValeur = isset($dates[$week]) ? $dates[$week] : 0;
            $dates[$week] = $ancienValeur + 1;
        }

        $datePublication2 = array();
        $dates2 = array();
        foreach ($datePublication as $key => $value) {
            $datePublication2[] = [intval($key), $value];
        }

        foreach ($dates as $key => $value) {
            $dates2[] = [intval($key), $value];
        }
        usort($dates2, function($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
        usort($datePublication2, function($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });

        // Chart
        $series = array(
            array("name" => "Evènements Publiées",    "data" => $datePublication2)
        );

        $obPublication = new Highchart();
        $obPublication->chart->renderTo('linechartPublication');  // The #id of the div where to render the chart
        $obPublication->title->text('Nombre d\'évènements publié par semaine de l\'année sur le site');
        $obPublication->xAxis->title(array('text'  => "Semaine"));
        $obPublication->xAxis->allowDecimals(false);
        $obPublication->yAxis->allowDecimals(false);
        $obPublication->yAxis->title(array('text'  => "Nombre d\'évènements publié"));
        $obPublication->series($series);

        // Chart
        $series = array(
            array("name" => "Evènements Par Semaine",    "data" => $dates2)
        );

        $obRealisation = new Highchart();
        $obRealisation->chart->renderTo('linechartRealisation');  // The #id of the div where to render the chart
        $obRealisation->title->text('Nombre d\'évènements réalisé par semaine de l\'année sur le site');
        $obRealisation->xAxis->title(array('text'  => "Semaine"));
        $obRealisation->xAxis->allowDecimals(false);
        $obRealisation->yAxis->allowDecimals(false);
        $obRealisation->yAxis->title(array('text'  => "Nombre d\'évènements publié"));
        $obRealisation->series($series);

        $obRealisation->xAxis->categories($this->mois);
        $obPublication->xAxis->categories($this->mois);

        $eventCharts = ["publication" => $obPublication, "realisation" => $obRealisation];
        return $eventCharts;
    }

    /** Méthode qui retourne le numéro de semaine par mois **/
    public function initialiseMois()
    {
        $mois = ['1er Semaine - Janvier', '2éme Semaine - Janvier','3éme Semaine - Janvier','4éme Semaine - Janvier',
        '1er Semaine - Fevrier', '2éme Semaine - Fevrier', '3éme Semaine - Fevrier', '4éme Semaine - Fevrier',
         '1er Semaine - mars', '2éme Semaine - mars', '3éme Semaine - mars', '4éme Semaine - mars', '5éme Semaine - mars',
          '1er Semaine - Avril', '2éme Semaine - Avril', '3éme Semaine - Avril', '4éme Semaine - Avril',
          '1er Semaine - Mai', '2éme Semaine - Mai', '3éme Semaine - Mai', '4éme Semaine - Mai',
          '1er Semaine - Juin', '2éme Semaine - Juin', '3éme Semaine - Juin', '4éme Semaine - Juin', '5éme Semaine - Juin',
          '1er Semaine - Juillet', '2éme Semaine - Juillet', '3éme Semaine - Juillet', '4éme Semaine - Juillet',
          '1er Semaine - Août', '2éme Semaine - Août', '3éme Semaine - Août', '4éme Semaine - Août', '5éme Semaine - Août/Septembre',
          '1er Semaine - Septembre', '2éme Semaine - Septembre', '3éme Semaine - Septembre', '4éme Semaine - Septembre',
          '1er Semaine - October', '2éme Semaine - October', '3éme Semaine - October', '4éme Semaine - October',
          '1er Semaine - Novembre', '2éme Semaine - Novembre', '3éme Semaine - Novembre', '4éme Semaine - Novembre', '5éme Semaine - Novembre',
          '1er Semaine - Decembre', '2éme Semaine - Decembre', '3éme Semaine - Decembre', '4éme Semaine - Decembre'];
          return $mois;
    }
}
