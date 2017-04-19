<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SponsorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
                ->add('telephone', TextType::class, ["required" => false])
                ->add('email', EmailType::class)
                ->add('siteWeb', TextType::class, ["required" => false])
                ->add('montant', NumberType::class, ["label" => "Montant payé par le sponsor"
                                                    ,"mapped" => false
                ])
                ->add('adresse', TextType::class, ["required" => false])
                ->add('logo', FileType::class, ["label" => "Logo", "required" => false])
                ->add('creer', ChoiceType::class, array('choices' => array("true" => true),
                                                        "expanded" => true, "multiple" => true,
                                                        "attr" => array("hidden" => true),
                                                        "label" => false,"mapped" => false)
                );

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Sponsor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_sponsor';
    }


}
