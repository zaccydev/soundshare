<?php

namespace SoundShare\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', 'text', ['attr' => ['name' => '_username']]);
        $builder->add('password', 'password');
        $builder->add('captcha', 'captcha', ['reload' => true, 'as_url' => true]);

        $builder->add('submit', 'submit', array("label" => "login"));
    }


    public function getName()
    {
        return 'login';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'authenticate',
            'csrf_protection' => true,
            'csrf_field_name' => 'csrf_token',
            //'csrf_provider' => new DefaultCsrfProvider() //'form.csrf_provider'
            //'data_class' => 'SoundShare\CommunityBundle\Entity\User',
        ));
    }
    
}

