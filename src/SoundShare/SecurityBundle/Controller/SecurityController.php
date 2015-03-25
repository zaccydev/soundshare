<?php

namespace SoundShare\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use SoundShare\SecurityBundle\Form\LoginType;
use SoundShare\SecurityBundle\Exception\SSBAuthenticationException;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $form = $this->createForm(new LoginType(),[],['action' => $this->generateUrl('ss_login_check')]);
      
        
        $session = $request->getSession();
        //$session->set('captcha_submit_value', 'mytestval'); //$form->get('captcha')->getData()
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            //$error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $error = new SSBAuthenticationException();
            
            die("case 1");
        }
        elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            //$error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);            
            $error = new SSBAuthenticationException();
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
           
           
            
        }       
        else {
            $error = '';                
        }
        
        $login = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);
        
        
        return $this->render('SoundShareSecurityBundle:Security:login.html.twig', array('form' => $form->createView(), 'error' =>$error));
    }
}
