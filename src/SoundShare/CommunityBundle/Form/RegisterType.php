<?php

namespace SoundShare\CommunityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', 'text');
        $builder->add('email', 'email');
        $builder->add('password', 'password');
        $builder->add('country', 'country');
        $builder->add('presentation', 'textarea');
        $builder->add('musicStyles', 'entity', 
                array('class' => 'SoundShareCommunityBundle:MusicStyles',               
                      'multiple' => 1));
        $builder->add('register', 'submit', array("label" => "ok"));
        
        /*$builder->addEventListener(FormEvents::PRE_SUBMIT, function($event) {
            if (! $event->getForm()->has('password')) {
                $event->getForm()->add('password', 'password');
            }
        });*/
    }

    public function getName()
    {
        return 'register';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SoundShare\CommunityBundle\Entity\User',
            'validation_groups' => function(\Symfony\Component\Form\FormInterface $form) {
                if ($form->has('password')) {
                       return ['common', 'registration' ];
                }
                return ['common'];
            },
        ));
    }

}
