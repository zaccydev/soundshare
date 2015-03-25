<?php

namespace SoundShare\CommunityBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


/**
 * Unused
 * 
 * Subscriber for the registration/update account form
 * 
 */

class UserAccountUpdateSubscriber implements EventSubscriberInterface
{
    private $userPassValue = null;
    
    public function onUserAccountUpdate(FormEvent $event) {
       
        $event->getData()->disablePasswordChange();
    }
    
    public static function getSubscribedEvents()
    {
        return array(        
            FormEvents::PRE_SUBMIT => 'onUserAccountUpdate',
        );
    }
    
    
    public function setUserPassValue($upv) {
        $this->userPassValue = $upv;
    }

}
