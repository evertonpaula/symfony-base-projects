<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Epsoftware\UserBundle\Form\LoginFormType;
use Epsoftware\UserBundle\Entity\User;


class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function loginAction()
    {
        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return array('last_username' => $lastUsername,'error' => $error, 'form' => $form->createView());
    }
    
    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}
