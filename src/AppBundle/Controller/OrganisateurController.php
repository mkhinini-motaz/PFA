<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Organisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Organisateur controller.
 *
 * @Route("organisateur")
 */
class OrganisateurController extends Controller
{
    /**
     * Lists all organisateur entities.
     *
     * @Route("/", name="organisateur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organisateurs = $em->getRepository('AppBundle:Organisateur')->findAll();

        return $this->render('organisateur/index.html.twig', array(
            'organisateurs' => $organisateurs,
        ));
    }

    /**
     * Creates a new organisateur entity.
     *
     * @Route("/new", name="organisateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $organisateur = new Organisateur();
        $form = $this->createForm('AppBundle\Form\OrganisateurType', $organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organisateur);
            $em->flush($organisateur);

            return $this->redirectToRoute('organisateur_show', array('id' => $organisateur->getId()));
        }

        return $this->render('organisateur/new.html.twig', array(
            'organisateur' => $organisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a organisateur entity.
     *
     * @Route("/{id}", name="organisateur_show")
     * @Method("GET")
     */
    public function showAction(Organisateur $organisateur)
    {
        $deleteForm = $this->createDeleteForm($organisateur);

        return $this->render('organisateur/show.html.twig', array(
            'organisateur' => $organisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing organisateur entity.
     *
     * @Route("/{id}/edit", name="organisateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Organisateur $organisateur)
    {
        $deleteForm = $this->createDeleteForm($organisateur);
        $editForm = $this->createForm('AppBundle\Form\OrganisateurType', $organisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('organisateur_edit', array('id' => $organisateur->getId()));
        }

        return $this->render('organisateur/edit.html.twig', array(
            'organisateur' => $organisateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a organisateur entity.
     *
     * @Route("/{id}", name="organisateur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Organisateur $organisateur)
    {
        $form = $this->createDeleteForm($organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organisateur);
            $em->flush($organisateur);
        }

        return $this->redirectToRoute('organisateur_index');
    }

    /**
     * Creates a form to delete a organisateur entity.
     *
     * @param Organisateur $organisateur The organisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Organisateur $organisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organisateur_delete', array('id' => $organisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
