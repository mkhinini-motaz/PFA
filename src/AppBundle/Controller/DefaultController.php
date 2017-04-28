<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Event');

        $events = $repo->findAllRecent();

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
            ])
            ->add('lieu', ChoiceType::class, ['multiple' => true,
                                              'expanded' => true,
                                              'choices' => $lieux,
                                              'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $events = $repo->findAllRecherche($data["motcle"], $data["lieu"], $data["categories"]);
        }

        return $this->render('default/index.html.twig', array('events' => $events, 'searchForm' => $form->createView()) );
    }

    /**
     * @Route("/eventPassee", name="event_passee")
     */
    public function eventPasseeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Event');

        $events = $repo->findAllPasse();
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
            ])
            ->add('lieu', ChoiceType::class, ['multiple' => true,
                                              'expanded' => true,
                                              'choices' => $lieux,
                                              'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $events = $repo->findAllRecherche($data["motcle"], $data["lieu"], $data["categories"]);
        }
        return $this->render('default/index.html.twig',
            array('events' => $events, 'searchForm' => $form->createView()) );


    }
}
