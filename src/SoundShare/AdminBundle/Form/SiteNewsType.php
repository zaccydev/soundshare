<?php

namespace SoundShare\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteNewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('soundPath')
            ->add('imagePath')
            ->add('summary')
            ->add('content')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SoundShare\AdminBundle\Entity\SiteNews'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'soundshare_adminbundle_sitenews';
    }
}
