<?php

namespace SoundShare\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SoundShareAdminBundle:Default:index.html.twig');
    }
}
