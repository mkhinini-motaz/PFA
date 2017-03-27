<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EventFermeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
                ->add('description', TestareaType::class)
                ->add('lieu', TextType::class)
                ->add('categories', ChoiceType::class, [
                                 'choices' => $options["categories"] ])
                ->add('capacite', IntegerType::class)
                ->add('dateDebutInscri', DateType::class)
                ->add('dateFinInscri', DateType::class)
                ->add('prix', IntegerType::class)
                ->add('photo', FileType::class, ["label" => "Photo de l'évennement"])
                ->add('fichiers', FileType::class, ["multiple" => true, "label" => "Fichiers joints"]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\EventFerme',
            'categories' => null, 
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_eventferme';
    }


}
