<?php

namespace SoundShare\CommunityBundle\Controller;


use SoundShare\CommunityBundle\Form\UploadSoundType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DefaultController extends Controller {

    public function indexAction() {       
        
        $em = $this->getDoctrine()->getManager();
        $soundRep = $em->getRepository('SoundShareCommunityBundle:SoundFile');
        if (is_object($this->getUser())) {
            //dump($this->getUser());
            $sounds = $soundRep->getPublicAndFriendSounds($this->getUser()->getId());
        } else {
            $sounds = $soundRep->findBy(['isPublic' => 1], ['addedOn' => 'DESC']);
        }
                
        return $this->render('SoundShareCommunityBundle:Default:index.html.twig', array('sounds' => $sounds));
    }    
    
    public function uploadSoundAction(Request $request) {
        
        $form = $this->createForm(new UploadSoundType($this->getUser())); 
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {           
            $em = $this->getDoctrine()->getManager();
            $sound = $form->getData();            
            $sound->setUser($this->getUser());
            $em->persist($form->getData());
            $em->flush();            
            $request->getSession()->getFlashBag()->set('notice', 'you have uploaded a new file, thank you for your participation !');        
            return $this->redirect($this->generateUrl('sound_share_community_homepage'));
        }
        
        return $this->render('SoundShareCommunityBundle:Default:sound-upload.html.twig', 
                array('form' => $form->createView(),));
    }
    
    public function getSoundResourceAction($fileName) {
        
        return new BinaryFileResponse($this->container->getParameter('kernel.root_dir') . '/Resources/sounds/' . $fileName);
        
    }

}
