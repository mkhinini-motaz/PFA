<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SponsorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
                ->add('telephone', TextType::class)
                ->add('email', EmailType::class)
                ->add('siteWeb', TextType::class)
                ->add('adresse', TextType::class)
                ->add('logo', FileType::class, ["label" => "Logo"])
                ->add('creer', ChoiceType::class, array('choices' => array("true" => true),
                                                        "expanded" => true, "multiple" => true,
                                                        //"attr" => array("hidden" => true),
                                                        "label" => false,"mapped" => false))
                ;

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
