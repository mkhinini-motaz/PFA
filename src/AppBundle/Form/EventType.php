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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ouvertCheck', CheckboxType::class, ['label' => 'Ouvert (Nombre de place illimité)'
                                                           ,'required' => false
                ])

                ->add('gratuitCheck', CheckboxType::class, ['label' => 'Gratuit'
                                                            ,'required' => false
                ])

                ->add('nom', TextType::class)

                ->add('description', TextareaType::class)

                ->add('lieu', TextType::class)

                ->add('categories', EntityType::class, ['class' => 'AppBundle:Categorie',
                                                        'choice_label' => 'getNomAndCount',
                                                        'label' => 'Categories',
                                                        'multiple' => true,
                                                        'expanded' => true,
                                                        'query_builder' => function (EntityRepository $er) {
                                                                    return $er->createQueryBuilder('c')
                                                                              ->where('c.accepte = true');
                                                                          },
                ])

                ->add('date', DateTimeType::class, ["years" => range(date("Y"), strval(intval(date("Y")) + 7))
                                                   ,"label" => "Date debut de l'évennement"
                ])
                ->add('dateFin', DateTimeType::class, ["years" => range(date("Y"), strval(intval(date("Y")) + 7))
                                                   ,"label" => "Date fin de l'évennement"
                ])

                ->add('dateDebutInscri', DateType::class, ["years" => range(date("Y"), strval(intval(date("Y")) + 7))
                                                          ,"required" => false
                                                          ,"label" => "Date debut de l'inscription"
                                                           ])

                ->add('dateFinInscri', DateType::class, ["years" => range(date("Y"), strval(intval(date("Y")) + 7))
                                                          ,"required" => false
                                                          ,"label" => "Date fin de l'inscription"
                                                        ])

                ->add('capacite', IntegerType::class, ["label" => "Capacité de l'évennement"
                                                      ,"required" => false
                                                      ,"attr" => ["min" => 1]
                ])

                ->add('prix', NumberType::class, ["required" => false])

                ->add('photo', FileType::class, ["label" => "Photo de l'évennement", "required" => false
                                                ,"attr" => ["accept" => ".png,.jpg,.jpeg"]
                ])

                ->add('fichiers', FileType::class, ["multiple" => true,
                                                    "label" => "Fichiers joints",
                                                    "required" => false
                                                    ,"attr" => ["accept" => ".png,.jpg,.jpeg,.pdf"]
                ]);
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
