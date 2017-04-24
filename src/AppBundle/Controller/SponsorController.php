<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Sponsor;
use AppBundle\Entity\Event;
use AppBundle\Entity\Sponsoring;



/**
 * Sponsor controller.
 *
 * @Route("sponsor")
 */
class SponsorController extends Controller
{
    /**
     * Lists all sponsor entities.
     *
     * @Route("/", name="sponsor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sponsors = $em->getRepository('AppBundle:Sponsor')->findAll();

        return $this->render('sponsor/index.html.twig', array(
            'sponsors' => $sponsors,
        ));
    }

    /**
     * Creates a new sponsor entity.
     *
     * @Route("/new", name="sponsor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sponsor = new Sponsor();
        $form = $this->createForm('AppBundle\Form\SponsorType', $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $path = $this->get('kernel')->getRootDir() . '/../web/images/sponsor/' . $event->getName();

            $logo = $sponsor->getLogo();
            $logoName = md5(uniqid()).'.'.$logo->guessExtension();
            move_uploaded_file($logo->getPathName() , $path . DIRECTORY_SEPARATOR . $logoName);
            $sponsor->setLogo($logoName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsor);
            $em->flush($sponsor);

            return $this->redirectToRoute('sponsor_show', array('id' => $sponsor->getId()));
        }

        return $this->render('sponsor/new.html.twig', array(
            'sponsor' => $sponsor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Créer une nouvelle entité Sponsor et l'associe à l'objet Event passé en paramétre
     *
     * @Route("/new/{id}", name="sponsor_new_for_event")
     * @Method({"GET", "POST"})
     * @ParamConverter("event", class="AppBundle:Event")
     */
    public function newForEventAction(Request $request, Event $event)
    {
        $sponsor = new Sponsor();
        $form = $this->createForm('AppBundle\Form\SponsorType', $sponsor);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $path = $this->get('kernel')->getRootDir() . '/../web/images/sponsor';

            if($sponsor->getLogo() !== null){
                $logo = $sponsor->getLogo();
                $logoName = md5(uniqid()).'.'.$logo->guessExtension();
                move_uploaded_file($logo->getPathName() , $path . DIRECTORY_SEPARATOR . $logoName);
                $sponsor->setLogo($logoName);
            }

            $sponsoring = new Sponsoring();
            $sponsoring->setSponsor($sponsor);
            $sponsoring->setEvent($event);
            $sponsoring->setMontant($form['montant']->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsoring);
            $em->persist($sponsor);
            $em->persist($event);
            $em->flush($sponsor);

            /* Condition pour vérifer la valeur du checkbox ne marche pas */
                    /* || */
                    /* \/ */
            if($form['creer']->getData()){
                $sponsor = new Sponsor();
                return $this->render('sponsor/new_for_event.html.twig', array(
                    'sponsor' => $sponsor,
                    'form' => $form->createView(),
                ));

            }else {
                return $this->redirectToRoute('event_show', array('id' => $event->getId()));
            }
        }

        return $this->render('sponsor/new_for_event.html.twig', array(
            'sponsor' => $sponsor,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a sponsor entity.
     *
     * @Route("/{id}", name="sponsor_show")
     * @Method("GET")
     */
    public function showAction(Sponsor $sponsor)
    {
        $deleteForm = $this->createDeleteForm($sponsor);

        return $this->render('sponsor/show.html.twig', array(
            'sponsor' => $sponsor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sponsor entity.
     *
     * @Route("/{id}/edit", name="sponsor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sponsor $sponsor)
    {
        $deleteForm = $this->createDeleteForm($sponsor);
        $editForm = $this->createForm('AppBundle\Form\SponsorType', $sponsor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sponsor_edit', array('id' => $sponsor->getId()));
        }

        return $this->render('sponsor/edit.html.twig', array(
            'sponsor' => $sponsor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sponsor entity.
     *
     * @Route("/{id}", name="sponsor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sponsor $sponsor)
    {
        $form = $this->createDeleteForm($sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sponsor);
            $em->flush($sponsor);
        }

        return $this->redirectToRoute('sponsor_index');
    }

    /**
     * Creates a form to delete a sponsor entity.
     *
     * @param Sponsor $sponsor The sponsor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sponsor $sponsor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sponsor_delete', array('id' => $sponsor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
