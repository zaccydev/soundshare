<?php

namespace Acme\DemoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        
        //$request = Request::createFromGlobals();
        $session = $this->get('session');
        $session->set('test', 'test');
        var_dump($this->getUser());
        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }
}
