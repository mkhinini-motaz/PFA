<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Event controller.
 *
 * @Route("event")
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('AppBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ( ($event->getPhoto() !== null) || ($event->getFichiers() !== null) ) {
                $path = $this->get('kernel')->getRootDir() . '/../web/images/events/' . $event->getNom();
                if ( ! is_dir($path) ) {
                  mkdir($path, 0777, true);
                }
            }
            if ($event->getPhoto() !== null) {
                // Déplacement de la photo
                $photo = $event->getPhoto();
                $photoName = md5(uniqid()) . '.' . $photo->guessExtension();
                move_uploaded_file($photo->getPathName() , $path . DIRECTORY_SEPARATOR . $photoName);
                $event->setPhoto($photoName);
            }

            if ($event->getFichiers() !== null) {
                // String qui va contenir les noms des images séparés par " ; "
                $filesnames = "";

                // Déplacement des fichiers
                foreach ($event->getFichiers() as &$file){
                  $fileName = md5(uniqid()).'.'.$file->guessExtension();
                  move_uploaded_file($file->getPathName() ,$path . DIRECTORY_SEPARATOR .$fileName);
                  $filesnames .= $fileName . ";";
                }
                $event->setFichiers(substr($filesnames, 0, -1));
            }

            $event->setDatePublication(new \DateTime("now", new \DateTimeZone("Africa/Tunis")));
            $em->persist($event);
            $em->flush($event);

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}", name="event_show")
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {

        $photoName = $event->getPhoto();

        $path = $this->get('kernel')->getRootDir() . '/../web/images/events/' . $event->getNom();
        $photoPath = $path . DIRECTORY_SEPARATOR . $event->getPhoto();

        $event->setPhoto(new File($photoPath));

        $fichiers = [];
        $nomFichiers = explode(";", $event->getFichiers());

        foreach ( $nomFichiers as $file ){
          $filePath = $path . DIRECTORY_SEPARATOR . $file;
          $fichiers[] = new File($filePath);
        }

        $event->setFichiers($fichiers);

        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
          // Déplacement de la photo
          $event->setPhoto($photoName);
          $event->setFichiers(implode(";", $nomFichiers));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush($event);
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
