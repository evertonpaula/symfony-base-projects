<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\UserBundle\Entity\User;
use Epsoftware\UserBundle\Form\RegisterFormType;

class RegisterLoginController extends Controller
{
    /**
     * @Route("/register", name="register_user")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()):
            $user->setIsAccountNonLocked(true);
            $user->setIsAccountNonExpired(true);
            $user->setIsCredentialNonExpired(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("success_register");
        endif;
        return array("form" => $form->createView());
    }
    
    /**
     * @Route("/register/authentication/user/{uri}", 
     *        name="register_user_authentication",
     *        
     *       )
     * @Method("GET")
     * @Template()
     */
    public function authenticationAction($uri)
    {
        return array("uri"=>$uri);
    }
    
    /**
     * Enviar e-mail para confirmação de conta
     * Utiliza o serviço send mail
     * @param \Epsoftware\UserBundle\Entity\User $user
     */
    private function sendEmail(User $user)
    {
        $mail = $this->get("epsoftware.services.mail");
        $mail->createEmail(
                    "Login Criado com Sucesso",
                    "epsoftware@epsoftware.com.br",
                    array($user->getEmail()),
                    "UserBundle:Mail:authentication.html.twig",
                    array("user" => $user->toArray())
                );
        $mail->sendEmail();
    }
}