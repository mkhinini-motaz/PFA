<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Abonne;
use AppBundle\Entity\Categorie;

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

        $obInscriptions = $this->createInscriptionsChart();

        $params = [ 'chartReservation' => $obReservations
                   ,'chartVue' => $obVue
                   ,'chartPublication' => $obEvent["publication"]
                   ,'chartRealisation' => $obEvent["realisation"]
                   ,'chartInscription' => $obInscriptions
                  ];

        return $this->render('admin/index.html.twig', $params );

    }

    /**
     * Liste des évents organisé par abonne
     *
     * @Route("/eventsorganise/{id}", name="events_organise")
     */
    public function eventsOrganiseAction(Abonne $abonne)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findByAbonne($abonne);

        return $this->render('event/mesevents.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Liste des évents participé par abonne
     *
     * @Route("/eventsparticipe/{id}", name="events_participe")
     */
    public function eventsParticipeAction(Abonne $abonne)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Reservation')->findByAbonne($abonne);

        return $this->render('event/mesevents.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Liste des évents
     *
     * @Route("/events", name="admin_events")
     */
    public function eventsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render('event/mesevents.html.twig', array(
            'events' => $events,
        ));
    }


    /**
     * @Route("/categories", name="admin_categories")
     */
    public function categoriesAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $categories = $this->em->getRepository('AppBundle:Categorie')->findBy(array(), ['id' => 'desc']);
        return $this->render('admin/categories.html.twig', ['categories' => $categories] );
    }

    /**
    * @Route("/categories/{id}", name="admin_categories_activer")
    * @ParamConverter("categorie", class="AppBundle:Categorie")
    */
    public function activerAction(Categorie $categorie)
    {
        $this->em = $this->getDoctrine()->getManager();
        $categorie->setAccepte(true);
        $this->em->persist($categorie);
        $this->em->flush();
        return $this->categoriesAction();
    }

    /**
    * @Route("/categories/{id}", name="admin_categories_supprimer")
    * @ParamConverter("categorie", class="AppBundle:Categorie")
    */
    public function supprimerAction(Categorie $categorie)
    {
        $this->em = $this->getDoctrine()->getManager();
        $categorie->setAccepte(true);
        $this->em->persist($categorie);
        $this->em->flush();
        return $this->categoriesAction();
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

/*************************************************************************************************************/
    public function createInscriptionsChart()
    {
        $users = $this->em->getRepository('AppBundle:Compte')->findAll();
        $data = array();
        foreach ($users as $user) {
            $week = $user->getDateInscription()->format('W');
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
            array("name" => "Inscriptions",    "data" => $data2)
        );

        $obInscriptions = new Highchart();
        $obInscriptions->chart->renderTo('linechartInscription');  // The #id of the div where to render the chart
        $obInscriptions->title->text('Nombre d\'inscriptions par semaine de l\'année sur le site');
        $obInscriptions->xAxis->title(array('text'  => "Semaine"));
        $obInscriptions->xAxis->allowDecimals(false);
        $obInscriptions->yAxis->allowDecimals(false);
        $obInscriptions->yAxis->title(array('text'  => "Nombre d'inscriptions"));
        $obInscriptions->series($series);
        $obInscriptions->xAxis->categories($this->mois);
        return $obInscriptions;
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
        $mois = ['1er Semaine - Janvier', '2éme Semaine - Janvier','3éme Semaine - Janvier','4éme Semaine - Janvier', '5éme semaine - Janvier', 'Fin Janvier / Debut Fevrier',
         '2éme Semaine - Fevrier', '3éme Semaine - Fevrier', '4éme Semaine - Fevrier',
         'Fin Fevrier / Debut Mars', '2éme Semaine - Mars', '3éme Semaine - Mars', '4éme Semaine - Mars', 'fin Mars / Début Avril',
          '2éme Semaine - Avril', '3éme Semaine - Avril', '4éme Semaine - Avril', '5éme Semaine - Avril',
          '1er Semaine - Mai', '2éme Semaine - Mai', '3éme Semaine - Mai', '4éme Semaine - Mai', 'Fin Mai / Debut Juin',
           '2éme Semaine - Juin', '3éme Semaine - Juin', '4éme Semaine - Juin', '5éme Semaine - Juin',
          '1er Semaine - Juillet', '2éme Semaine - Juillet', '3éme Semaine - Juillet', '4éme Semaine - Juillet',
          '1er Semaine - Août', '2éme Semaine - Août', '3éme Semaine - Août', '4éme Semaine - Août', '5éme Semaine - Août/Septembre',
          '1er Semaine - Septembre', '2éme Semaine - Septembre', '3éme Semaine - Septembre', '4éme Semaine - Septembre',
          '1er Semaine - October', '2éme Semaine - October', '3éme Semaine - October', '4éme Semaine - October',
          '1er Semaine - Novembre', '2éme Semaine - Novembre', '3éme Semaine - Novembre', '4éme Semaine - Novembre', '5éme Semaine - Novembre',
          '1er Semaine - Decembre', '2éme Semaine - Decembre', '3éme Semaine - Decembre', '4éme Semaine - Decembre'];
          return $mois;
    }
}
