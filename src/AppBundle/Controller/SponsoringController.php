<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sponsoring;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sponsoring controller.
 *
 * @Route("sponsoring")
 */
class SponsoringController extends Controller
{
    /**
     * Lists all sponsoring entities.
     *
     * @Route("/", name="sponsoring_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sponsorings = $em->getRepository('AppBundle:Sponsoring')->findAll();

        return $this->render('sponsoring/index.html.twig', array(
            'sponsorings' => $sponsorings,
        ));
    }

    /**
     * Creates a new sponsoring entity.
     *
     * @Route("/new", name="sponsoring_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sponsoring = new Sponsoring();
        $form = $this->createForm('AppBundle\Form\SponsoringType', $sponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsoring);
            $em->flush($sponsoring);

            return $this->redirectToRoute('sponsoring_show', array('id' => $sponsoring->getId()));
        }

        return $this->render('sponsoring/new.html.twig', array(
            'sponsoring' => $sponsoring,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sponsoring entity.
     *
     * @Route("/{id}", name="sponsoring_show")
     * @Method("GET")
     */
    public function showAction(Sponsoring $sponsoring)
    {
        $deleteForm = $this->createDeleteForm($sponsoring);

        return $this->render('sponsoring/show.html.twig', array(
            'sponsoring' => $sponsoring,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sponsoring entity.
     *
     * @Route("/{id}/edit", name="sponsoring_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sponsoring $sponsoring)
    {
        $deleteForm = $this->createDeleteForm($sponsoring);
        $editForm = $this->createForm('AppBundle\Form\SponsoringType', $sponsoring);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sponsoring_edit', array('id' => $sponsoring->getId()));
        }

        return $this->render('sponsoring/edit.html.twig', array(
            'sponsoring' => $sponsoring,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sponsoring entity.
     *
     * @Route("/{id}", name="sponsoring_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sponsoring $sponsoring)
    {
        $form = $this->createDeleteForm($sponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sponsoring);
            $em->flush($sponsoring);
        }

        return $this->redirectToRoute('sponsoring_index');
    }

    /**
     * Creates a form to delete a sponsoring entity.
     *
     * @param Sponsoring $sponsoring The sponsoring entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sponsoring $sponsoring)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sponsoring_delete', array('id' => $sponsoring->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
