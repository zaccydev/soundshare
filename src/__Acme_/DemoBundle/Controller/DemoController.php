<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;
// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Symfony\Component\Validator\Constraints\NotBlank;

class DemoController extends Controller {

    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction() {
        $request = Request::createFromGlobals();
        var_dump($request->server->get('HTTP_HOST'));        
        return [];
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name) {
        return array('name' => $name);
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction(Request $request) {
        $form = $this->createForm(new ContactType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $mailer = $this->get('mailer');

            // .. setup a message and send it
            // http://symfony.com/doc/current/cookbook/email.html

            $request->getSession()->getFlashBag()->set('notice', 'Message sent!');

            return new RedirectResponse($this->generateUrl('_demo'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/myFormCtl", name="_form_ctl")
     * @Template()
     */
    public function mydemoFormFromCtlAction(Request $request) {
        $task = [ "task" => "create a blog post",
            "dueDate" => new \DateTime('tomorrow') ];
        $form = $this->createFormBuilder($task)
                ->add('task', 'text', array("required" => false, "constraints" => [new NotBlank()] ))
                ->add('dueDate', 'date')
                ->add('save', 'submit', array('label' => 'Create Task'))
                ->getForm();
        $form->handleRequest($request);
        return $this->render('AcmeDemoBundle:Demo:formctl.html.twig', array('form' => $form->createView(),
        ));
    }
}

