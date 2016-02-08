<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\UserBundle\Services\SuccessRegister;
use Epsoftware\UserBundle\Entity\User;
use Epsoftware\UserBundle\Entity\Permission;
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
            $permission = $this->getDoctrine()->getRepository(Permission::class)->findOneBy(array('role' => 'ROLE_USER'));
            $user->addPermission($permission);
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
     * @Route("/register/authentication/user/{uri}", name="register_user_authentication")
     * @Method("GET")
     * @Template()
     */
    public function authenticationAction($uri)
    {
        try{
            /**
             * @var \Epsoftware\UserBundle\Entity\User
             */
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('uri' => $uri));

            if($user === null):
                return array("error"=> true);
            endif;
            if(!$user->getIsEnable()):
                $user->setIsEnable(true);
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();
            endif;
            return array("error"=> false, "user" => $user->toArray());
            
        }catch (\Exception $ex){
            throw new \Exception($ex);
        }
        
    }
    
    /**
     * @Route("/register/success", name="success_register")
     * @Template()
     * @Method({"GET"})
     */
    public function successRegisterAction()
    {
        $success = new SuccessRegister();
        return $success->getTwigParameters();
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