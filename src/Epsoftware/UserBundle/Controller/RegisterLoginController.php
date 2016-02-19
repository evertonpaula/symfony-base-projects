<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\UserBundle\Entity\User;
use Epsoftware\UserBundle\Entity\Permission;
use Epsoftware\UserBundle\Form\RegisterFormType;

class RegisterLoginController extends Controller
{
    private $local = "Registrar";
    
    /**
     * @Route("/register", name="register_user")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $action = "Novo Registro";
        
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
            $this->sendEmail($user);
            $this->logger($action, "Novo registro de usuário no sistema, {$user->getUsername()}");
            return $this->get("epsoftware.mensageria.render.callback")
                        ->render("Tudo ok, parabéns pelo cadastro.","Seu registro foi efetuado com sucesso.","Em breve você receberá no e-mail as instruções de ativação de seu usuário.");
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
        $action = "Autenticação usuário";
        
        try{
            /**
             * @var \Epsoftware\UserBundle\Entity\User
             */
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('uri' => $uri));

            if($user === null):
                $this->logger($action, "Tentativa de autenticação no sistema");
                return array("error"=> true);
            endif;
            if(!$user->getIsEnable()):
                $user->setIsEnable(true);
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();
            endif;
            $this->logger($action, "Usuário autenticado com sucesso no sistema, {$user->getUsername()}");
            return array("error"=> false, "user" => $user->toArray());
        }catch (\Exception $ex){
            
            throw new \Exception($ex);
        }
        
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
                    array($user->getEmail()),
                    "UserBundle:Mail:authentication.html.twig",
                    array("user" => $user->toArray())
                );
        $mail->sendEmail();
    }
    
    public function logger($action, $observation = null)
    {
       $this->get("epsoftware.user.logger")->logger($this->local, $action, $this->getUser(), $observation); 
    }
}