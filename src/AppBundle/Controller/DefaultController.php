<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\QueryBuilder;

use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="homepage")
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Event');

        $events = $repo->findAllRecent($page);

        $data = array();
        $form = $this->createSearchForm($data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $events = $repo->findAllRecherche($data["motcle"], $data["lieu"], $data["categories"]);
        }

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($events) / 15),
            'nomRoute' => 'homepage',
            'paramsRoute' => array()
        );

        return $this->render('default/index.html.twig', array('events' => $events
                                                             ,'searchForm' => $form->createView()
                                                             ,'pagination' => $pagination
                                                         ));
    }

    /**
     * @Route("/eventPassee/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="event_passee")
     */
    public function eventPasseeAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Event');

        $events = $repo->findAllPasse();

        $data = array();

        $form = $this->createSearchForm($data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $events = $repo->findAllRecherche($data["motcle"], $data["lieu"], $data["categories"]);
        }

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($events) / 15),
            'nomRoute' => 'homepage',
            'paramsRoute' => array()
        );

        return $this->render('default/index.html.twig',
            array('events' => $events
                    ,'searchForm' => $form->createView()
                    ,'pagination' => $pagination) );


    }


    /***************************************************************************/

    public function createSearchForm($data)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Event');

        $data = $repo->findAllDistinctLieu();
        $lieux = array();
        foreach ($data as $value) {
            $lieux[$value['lieu']. " (" . $value['nombre'] . ")"] = $value['lieu'];

        }

        $data = array();

        $form = $this->createFormBuilder($data)
            ->add('motcle', TextType::class, ['label' => 'Mot Clé', 'required' => false,])
            ->add('categories', EntityType::class, ['class' => 'AppBundle:Categorie',
                                                    'choice_label' => 'getNomAndCount',
                                                    'multiple' => true,
                                                    'expanded' => true,
                                                    'required' => false,
                                                    'query_builder' => function (EntityRepository $er) {
                                                                return $er->createQueryBuilder('c')
                                                                          ->where('c.accepte = true')
                                                                          ->leftJoin('c.events','e')
                                                                          ->having('COUNT(e.id) > 0')
                                                                          ->groupBy('c.id');
                                                            },
            ])
            ->add('lieu', ChoiceType::class, ['multiple' => true,
                                              'expanded' => true,
                                              'choices' => $lieux,
                                              'required' => false,
            ])
            ->getForm();

        return $form;
    }
}
