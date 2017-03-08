<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Eventorganisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Eventorganisateur controller.
 *
 * @Route("eventorganisateur")
 */
class EventorganisateurController extends Controller
{
    /**
     * Lists all eventorganisateur entities.
     *
     * @Route("/", name="eventorganisateur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eventorganisateurs = $em->getRepository('AppBundle:Eventorganisateur')->findAll();

        return $this->render('eventorganisateur/index.html.twig', array(
            'eventorganisateurs' => $eventorganisateurs,
        ));
    }

    /**
     * Creates a new eventorganisateur entity.
     *
     * @Route("/new", name="eventorganisateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $eventorganisateur = new Eventorganisateur();
        $form = $this->createForm('AppBundle\Form\EventorganisateurType', $eventorganisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventorganisateur);
            $em->flush($eventorganisateur);

            return $this->redirectToRoute('eventorganisateur_show', array('id' => $eventorganisateur->getId()));
        }

        return $this->render('eventorganisateur/new.html.twig', array(
            'eventorganisateur' => $eventorganisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a eventorganisateur entity.
     *
     * @Route("/{id}", name="eventorganisateur_show")
     * @Method("GET")
     */
    public function showAction(Eventorganisateur $eventorganisateur)
    {
        $deleteForm = $this->createDeleteForm($eventorganisateur);

        return $this->render('eventorganisateur/show.html.twig', array(
            'eventorganisateur' => $eventorganisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing eventorganisateur entity.
     *
     * @Route("/{id}/edit", name="eventorganisateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Eventorganisateur $eventorganisateur)
    {
        $deleteForm = $this->createDeleteForm($eventorganisateur);
        $editForm = $this->createForm('AppBundle\Form\EventorganisateurType', $eventorganisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eventorganisateur_edit', array('id' => $eventorganisateur->getId()));
        }

        return $this->render('eventorganisateur/edit.html.twig', array(
            'eventorganisateur' => $eventorganisateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a eventorganisateur entity.
     *
     * @Route("/{id}", name="eventorganisateur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Eventorganisateur $eventorganisateur)
    {
        $form = $this->createDeleteForm($eventorganisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eventorganisateur);
            $em->flush($eventorganisateur);
        }

        return $this->redirectToRoute('eventorganisateur_index');
    }

    /**
     * Creates a form to delete a eventorganisateur entity.
     *
     * @param Eventorganisateur $eventorganisateur The eventorganisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Eventorganisateur $eventorganisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eventorganisateur_delete', array('id' => $eventorganisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
