<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Event;

/**
 * Categorie controller.
 *
 * @Route("categorie")
 */
class CategorieController extends Controller
{
    /**
     * Lists all categorie entities.
     *
     * @Route("/", name="categorie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Categorie')->findByAccepte(true);

        return $this->render('categorie/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new categorie entity.
     *
     * @Route("/new", name="categorie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm('AppBundle\Form\CategorieType', $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()->hasRole("ROLE_ADMIN"))
                $categorie->setAccepte(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush($categorie);

            $this->addFlash('notice', 'Demande envoyé à l\'administrateur avec succées');
            $this->addFlash('admin-categorie', 'Nouvelle categorie proposé par ' . $this->getUser()->getUserName());

            return $this->redirectToRoute('categorie_index', array('id' => $categorie->getId()));
        }

        return $this->render('categorie/new.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new categorie entity for Event.
     *
     * @Route("/new/{id}", name="categorie_new_for_event")
     * @Method({"GET", "POST"})
     * @ParamConverter("event", class="AppBundle:Event")
     */
    public function newForEventAction(Request $request, Event $event)
    {
        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('categories', EntityType::class, ['class' => 'AppBundle:Categorie',
                                                    'label' => 'Ajouter categorie à votre évènement',
                                                    'choice_label' => 'getNomAndCount',
                                                    'multiple' => true,
                                                    'expanded' => true,
                                                    'required' => false,
                                                    'query_builder' => function (EntityRepository $er) use($event) {
                                                                return $er->createQueryBuilder('c')
                                                                           ->andWhere('c.accepte = true AND c NOT IN (:categories)')
                                                                           ->setParameter('categories', $event->getCategories())
                                                                           ->groupBy('c.id');
                                                                },
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            var_dump($data);
            $categories = $form["categories"]->getData();
            foreach ($categories as $categorie) {
                $event->addCategory($categorie);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $this->addFlash('notice', 'Catégories ajouté avec succées');
            return $this->redirectToRoute('event_show', ["id" => $event->getId()]);

        }

        return $this->render('categorie/new_for_event.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorie entity.
     *
     * @Route("/{id}", name="categorie_show")
     * @Method("GET")
     */
    public function showAction(Categorie $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);

        return $this->render('categorie/show.html.twig', array(
            'categorie' => $categorie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorie entity.
     *
     * @Route("/{id}/edit", name="categorie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categorie $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);
        $editForm = $this->createForm('AppBundle\Form\CategorieType', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_edit', array('id' => $categorie->getId()));
        }

        return $this->render('categorie/edit.html.twig', array(
            'categorie' => $categorie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorie entity.
     *
     * @Route("/{id}", name="categorie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Categorie $categorie)
    {
        $form = $this->createDeleteForm($categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush($categorie);
        }

        return $this->redirectToRoute('categorie_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Categorie $categorie The categorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categorie $categorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorie_delete', array('id' => $categorie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
