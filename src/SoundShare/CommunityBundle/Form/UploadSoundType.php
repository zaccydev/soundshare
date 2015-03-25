<?php

namespace SoundShare\CommunityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class UploadSoundType extends AbstractType
{

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('isPublic', 'checkbox', ['label' => 'public ?']);
        $builder->add('file');
        $builder->add('style', 'entity', array('class' => 'SoundShareCommunityBundle:MusicStyles',
        ));
        $builder->add('upload', 'submit', array("label" => "ok"));

        /*$builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $event->getForm()->add('user', 'entity', ['class' => 'SoundShare\CommunityBundle\Entity\User']);
            $sound = $event->getdata(); //->setData(['user'=> $this->user]);
            dump($sound);
        });*/
    }

    public function getName()
    {
        return 'sound_upload';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SoundShare\CommunityBundle\Entity\SoundFile',
            'error_mapping' => ['fileTypeAllowed' => 'file'],
        ));
    }

}
