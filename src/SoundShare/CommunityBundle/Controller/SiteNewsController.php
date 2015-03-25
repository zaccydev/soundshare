<?php

namespace SoundShare\CommunityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use SoundShare\AdminBundle\Entity\SiteNews;

class SiteNewsController extends Controller {
    
    public function getLastNewsAction() {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('SoundShareAdminBundle:SiteNews');
        $news = $rep->findBy(array(), array("createdAt" => "DESC"), 10 );
        
        return $this->render('SoundShareCommunityBundle:SiteNews:last-news.html.twig', array('news' => $news));
    }
    
    public function getAllNewsAction() {
        
    }
    
    public function readOneNewsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('SoundShareAdminBundle:SiteNews');
        $news = $rep->findOneBy(['id' => $id]);
        
        return $this->render('SoundShareCommunityBundle:SiteNews:news.html.twig', array('news' => $news));
    }
}

