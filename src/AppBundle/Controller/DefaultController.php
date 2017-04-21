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

        $events = $em->getRepository('AppBundle:Event')->findAllRecent();

        $data = $em->getRepository('AppBundle:Event')->findAllDistinctLieu();
        $lieux = array();
        foreach ($data as $value) {
            $lieux[$value['lieu']] = $value['lieu'];
        }

        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('motcle', TextType::class, ['label' => 'Mot Clé', 'required' => false,])
            ->add('categories', EntityType::class, ['class' => 'AppBundle:Categorie',
                                                    'choice_label' => 'nom',
                                                    'multiple' => true,

                                                    'required' => false,
            ])
            ->add('lieu', ChoiceType::class, ['multiple' => true,

                                              'choices' => $lieux,
                                              'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            $events = $em->getRepository('AppBundle:Event')->findAllRecherche($data["motcle"]
                                                                            , $data["lieu"]
                                                                            , $data["categories"]);
        }

        return $this->render('default/index.html.twig', array('events' => $events, 'searchForm' => $form->createView()) );
    }
}
