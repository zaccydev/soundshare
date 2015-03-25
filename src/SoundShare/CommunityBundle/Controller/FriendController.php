<?php

namespace SoundShare\CommunityBundle\Controller;

use SoundShare\CommunityBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sendio\Bundle\JMS
// note that two use statements specific to route annotation
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class FriendController extends Controller
{

    /**
     * @Route("/member/list", name="ss_user_list")
     * @Method("GET")
     * 
     * // Secure(roles="ROLE_USER")  require JMS\SecurityExtraBundle\Annotation\Secure  -- the JMSSecurityExtraBundle
     * 
     */
    public function userListAction()
    {

        $em = $this->getDoctrine()->getManager();
        $userRep = $em->getRepository('SoundShareCommunityBundle:User');
        $users = $userRep->findBy([], ['login' => 'ASC']);

        return $this->render('SoundShareCommunityBundle:Friend:user-list.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/member/addFriend/{userId}/{userName}", name="ss_user_addfriend", requirements={"userId":"\d+"}, defaults={"userId"=0, "userName"="nameInitValue"}) 
     * 
     * 
     * @param type integer $userId
     */
    public function addFriendAction(Request $request, $userId, $userName)
    {

        $form = $this->createFormBuilder(['friendId' => $userId])
                ->add('friendId', 'hidden', array('constraints' => [new NotNull(), new Type('alnum')]))
                ->add('Confirm', 'submit')
                ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
           $em = $this->getDoctrine()->getManager();
           
           $userRep = $em->getRepository('SoundShareCommunityBundle:User');
           $user = $userRep->findOneBy(['id' => $this->getuser()->getId()]);
           $friend = $userRep->findOneBy(['id' => $form->getData()['friendId']]);
           $user->addMyFriend($friend);
           
           $em->persist($user);
           $em->flush();
           
           return $this->redirect($this->generateUrl('ss_user_list'));
        } 

        return $this->render('SoundShareCommunityBundle:Friend:add-friend-dialog.html.twig', ['form' => $form->createView(), 'fname' => $userName]);
    }

}
