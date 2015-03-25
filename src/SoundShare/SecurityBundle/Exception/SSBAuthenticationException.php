<?php

namespace SoundShare\SecurityBundle\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
/**
 * Description of AuthenticationException
 *
 * @author pierre
 */
class SSBAuthenticationException extends AuthenticationException
{       
    public function __construct() {
        // the code is not used...
        parent::__construct("Error during authentification either the username, password or captcha is not valid.", 302, null);
    }
    /**
     * Message key to be used by the translation component.
     *
     * @return string
    *   
    public function getMessageKey()
    {
        return 'An authentication exception occurred.';
    }
    /**
     * Message data to be used by the translation component.
     *
     * @return array
     *
    public function getMessageData()
    {
        return array('An authentication exception occurred.' => "Error during authentification either the username, password or captcha are not valid.");
    }*/
}
