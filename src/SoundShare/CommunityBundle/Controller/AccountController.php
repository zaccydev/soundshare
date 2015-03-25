<?php

namespace SoundShare\CommunityBundle\Controller;

use SoundShare\CommunityBundle\Entity\User;
use SoundShare\CommunityBundle\Form\RegisterType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller {    
    
    public function registerAction(Request $request) {
       
        $form = $this->createForm("register");
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $factory = $this->get('security.encoder_factory');
            $user = $form->getData();
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $request->getSession()->set('user', $form->getData());

            if ($this->sendRegistrationMail($form->getData())) {
                $request->getSession()->getFlashBag()->set('notice', 'mail was sent successfully ');
            } else {
                $request->getSession()->getFlashBag()->set('notice', 'problem detected during mail sending, you will be informed soon');
            }            
            
            return $this->redirect($this->generateUrl('sound_share_community_register_success'));
        }
        return $this->render('SoundShareCommunityBundle:Account:register.html.twig', 
                array('form' => $form->createView(),'editing' => false));
    }

    private function sendRegistrationMail(User $user) {

        $message = \Swift_Message::newInstance();
        $message->setSubject('SoundShare registration')
                ->setFrom(array('john@doe.com' => 'John Doe'))
                ->setTo([$user->getEmail()])
                ->setBody(
                        '<html>' .
                        ' <head></head>' .
                        ' <body>' .
                        ' You will be registered soon, to achieve that task follow the link with this mail <p><img src="' . // Embed the file
                        $message->embed(\Swift_Image::fromPath('radio_regmail.png')) .
                        '" alt="SoundShare Logo" /></p>' .
                        ' Hello welcome on SoundShare website ' .
                        ' </body>' .
                        '</html>', 'text/html' // Mark the content-type as HTML
        );
        return ($this->get('mailer')->send($message));        
    }

    public function registeredAction(Request $request) {
        if (null === $request->getSession()->get('user', null)) {
            return $this->redirect($this->generateUrl('sound_share_community_homepage'));
        }
        return $this->render('SoundShareCommunityBundle:Account:registered.html.twig');
    }

    public function accountAction(Request $request) {
        
        return $this->render('SoundShareCommunityBundle:Account:account.html.twig', 
                array('user' => $this->getUser()));
    }
    
    public function accountEditAction(Request $request) {
              
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SoundShareCommunityBundle:User')->find($this->getUser()->getId());
        $form = $this->createForm(new RegisterType, $entity);  
        $form->remove('password');         
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {             
            $em->flush();            
            return $this->redirect($this->generateUrl('ss_account'));
        }
        return $this->render('SoundShareCommunityBundle:Account:register.html.twig', 
                array('form' => $form->createView(), 'editing' => true));
    }
}



