<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EventFerme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Eventferme controller.
 *
 * @Route("eventferme")
 */
class EventFermeController extends Controller
{
    /**
     * Lists all eventFerme entities.
     *
     * @Route("/", name="eventferme_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eventFermes = $em->getRepository('AppBundle:EventFerme')->findAll();

        return $this->render('eventferme/index.html.twig', array(
            'eventFermes' => $eventFermes,
        ));
    }

    /**
     * Creates a new eventFerme entity.
     *
     * @Route("/new", name="eventferme_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $eventFerme = new Eventferme();
        $form = $this->createForm('AppBundle\Form\EventFermeType', $eventFerme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $path = $this->get('kernel')->getRootDir() . '/../web/images/events/' . $eventFerme->getNom();
            if ( ! is_dir($path) ) {
              mkdir($path, 0777, true);
            }

            // Déplacement de la photo
            $photo = $eventFerme->getPhoto();
            $photoName = md5(uniqid()).'.'.$photo->guessExtension();
            move_uploaded_file($photo->getPathName() , $path . DIRECTORY_SEPARATOR . $photoName);
            $eventFerme->setPhoto($photoName);

            // String qui va contenir les noms des images séparés par " ; "
            $filesnames = "";

            // Déplacement des fichiers
            foreach ($eventFerme->getFichiers() as &$file){
              $fileName = md5(uniqid()).'.'.$file->guessExtension();
              move_uploaded_file($file->getPathName() ,$path . DIRECTORY_SEPARATOR .$fileName);
              $filesnames .= $fileName . ";";
            }
            $eventFerme->setFichiers(substr($filesnames, 0, -1));

            $em = $this->getDoctrine()->getManager();
            $em->persist($eventFerme);
            $em->flush($eventFerme);

            return $this->redirectToRoute('eventferme_show', array('id' => $eventFerme->getId()));
        }

        return $this->render('eventferme/new.html.twig', array(
            'eventFerme' => $eventFerme,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a eventFerme entity.
     *
     * @Route("/{id}", name="eventferme_show")
     * @Method("GET")
     */
    public function showAction(EventFerme $eventFerme)
    {
        $deleteForm = $this->createDeleteForm($eventFerme);

        return $this->render('eventferme/show.html.twig', array(
            'eventFerme' => $eventFerme,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing eventFerme entity.
     *
     * @Route("/{id}/edit", name="eventferme_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EventFerme $eventFerme)
    {
        $deleteForm = $this->createDeleteForm($eventFerme);
        $editForm = $this->createForm('AppBundle\Form\EventFermeType', $eventFerme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eventferme_edit', array('id' => $eventFerme->getId()));
        }

        return $this->render('eventferme/edit.html.twig', array(
            'eventFerme' => $eventFerme,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a eventFerme entity.
     *
     * @Route("/{id}", name="eventferme_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EventFerme $eventFerme)
    {
        $form = $this->createDeleteForm($eventFerme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eventFerme);
            $em->flush($eventFerme);
        }

        return $this->redirectToRoute('eventferme_index');
    }

    /**
     * Creates a form to delete a eventFerme entity.
     *
     * @param EventFerme $eventFerme The eventFerme entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EventFerme $eventFerme)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eventferme_delete', array('id' => $eventFerme->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
