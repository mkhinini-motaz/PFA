<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Abonne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 * Abonne controller.
 */
class AbonneController extends Controller
{
    /**
     * Lists all abonne entities.
     *
     * @Route("/abonne/", name="abonne_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $abonnes = $em->getRepository('AppBundle:Abonne')->findAll();

        return $this->render('abonne/index.html.twig', array(
            'abonnes' => $abonnes,
        ));
    }

    /**
     * Creates a new abonne entity.
     *
     * @Route("/inscription", name="inscription")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $abonne = new Abonne();
        $form = $this->createForm('AppBundle\Form\AbonneType', $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $abonne->getCompte()->setEnabled(1);
            $abonne->getCompte()->addRole("ROLE_USER");
	        $abonne->getCompte()->setAbonne($abonne);

            $em->persist($abonne->getCompte());
            $em->persist($abonne);
            $em->flush($abonne);

            $dispatcher = $this->get('event_dispatcher');
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            $userManager->updateUser($abonne->getCompte());
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED
                            , new FilterUserResponseEvent($abonne->getCompte(), $request, $response));

            return $response;
        }

        return $this->render('abonne/new.html.twig', array(
            'abonne' => $abonne,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a abonne entity.
     *
     * @Route("/abonne/{id}", name="abonne_show")
     * @Method("GET")
     */
    public function showAction(Abonne $abonne)
    {
        $deleteForm = $this->createDeleteForm($abonne);

        return $this->render('abonne/show.html.twig', array(
            'abonne' => $abonne,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing abonne entity.
     *
     * @Route("abonne/{id}/edit", name="abonne_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Abonne $abonne)
    {
        $deleteForm = $this->createDeleteForm($abonne);
        $editForm = $this->createForm('AppBundle\Form\AbonneType', $abonne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('abonne_edit', array('id' => $abonne->getId()));
        }

        return $this->render('abonne/edit.html.twig', array(
            'abonne' => $abonne,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a abonne entity.
     *
     * @Route("/abonne/{id}", name="abonne_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Abonne $abonne)
    {
        $form = $this->createDeleteForm($abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonne);
            $em->flush($abonne);
        }

        return $this->redirectToRoute('abonne_index');
    }

    /**
     * Creates a form to delete a abonne entity.
     *
     * @param Abonne $abonne The abonne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Abonne $abonne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonne_delete', array('id' => $abonne->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
