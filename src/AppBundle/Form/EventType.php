<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
                ->add('description', TextareaType::class)
                ->add('lieu', TextType::class)
                ->add('categories', EntityType::class, ['class' => 'AppBundle:Categorie',
                                                        'choice_label' => 'nom',
                                                        'multiple' => true,
                                                        'expanded' => true,
                ])
                ->add('date', DateTimeType::class, ["years" => range(date("Y"), strval(intval(date("Y")) + 7))
                                                   ,"label" => "Date de l'évennement"
                                                   ])
                ->add('photo', FileType::class, ["label" => "Photo de l'évennement", "required" => false
                                                ,"attr" => ["accept" => ".png,.jpg,.jpeg"] ])
                ->add('fichiers', FileType::class, ["multiple" => true, "label" => "Fichiers joints", "required" => false
                                                    ,"attr" => ["accept" => ".png,.jpg,.jpeg,.pdf"]]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_event';
    }


}
