<?php

namespace SoundShare\SecurityBundle\Handler;


use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

use SoundShare\SecurityBundle\Exception\SSBAuthenticationException;
 
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {
 
    private $securityContext;
    private $router;
    
    public function __construct(SecurityContext $securityContext, Router $router) 
    {
        $this->securityContext = $securityContext;
        $this->router = $router;
    }
 
    public function onAuthenticationSuccess(Request $request, TokenInterface $token) 
    {        
        
        if ($request->request->get('login')) {
            $postdata = $request->request->get('login');
            $session = $request->getSession();
            $captchaData = $session->get('gcb_captcha');
            if ($captchaData['phrase'] != $postdata['captcha']) {                
                $this->securityContext->setToken(null);
                $request->getSession()->invalidate();                
                $session->set(SecurityContext::AUTHENTICATION_ERROR, new SSBAuthenticationException());   
               
                return new RedirectResponse($this->router->generate('ss_login'));
            }
            
            return new RedirectResponse($this->router->generate('sound_share_community_homepage'));
            
        }
        
    }
   
 
}
