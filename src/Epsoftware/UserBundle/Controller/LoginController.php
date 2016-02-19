<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Epsoftware\UserBundle\Form\LoginFormType;
use Epsoftware\UserBundle\Form\RecoveryPassFormType;
use Epsoftware\UserBundle\Entity\User;


class LoginController extends Controller
{
    private $local = "Login";
    
    /**
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function loginAction()
    {
        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);
        $formRecoveryPassword = $this->createForm(RecoveryPassFormType::class, $user, array("action"=>$this->generateUrl("recovery_password")));
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return array('last_username' => $lastUsername,'error' => $error, 'form' => $form->createView(), 'form_recovery_pass' => $formRecoveryPassword->createView());
    }
    
    /**
     * @Route("/login/recovery/password", name="recovery_password")
     * @Method({"POST"})
    */
    public function recoveryPassAction(Request $request)
    {
        $action = "Recuperação de senha";
        
        $email = $request->request->get("recovery_pass_form")["email"];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array("email" => $email));
        $form = $this->createForm(RecoveryPassFormType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() &&  $form->isValid() && $user):
            $newPassword = "N". base_convert(sha1(uniqid(mt_rand(), true)), 8, 36) . "P";
            $user->setPlainPassword($newPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->sendEmail($user, $newPassword);
            $this->logger($action, "Enviou nova senha para {$user->getEmail()}");
            return $this->get("epsoftware.mensageria.render.callback")
                        ->render("Tudo ok!!! Nova senha gerada com sucesso.","Uma nova senha foi enviada com sucesso para seu e-mail.","Abra seu e-mail confira a nova senha e acesse o sistema.");
        endif;
        
         return $this->get("epsoftware.mensageria.render.callback")
                     ->setCode(100)
                     ->render("Oops! houve um problema."," Desculpe, mas o e-mail informado não é valído.Caso não você tenha esquecido seu e-mail entre em contato com administrador do sistema para pedir orientação.","", false);
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
    
    /**
     * Enviar e-mail para confirmação de conta
     * Utiliza o serviço send mail
     * @param \Epsoftware\UserBundle\Entity\User $user
     */
    private function sendEmail(User $user, $newPassword)
    {
        $mail = $this->get("epsoftware.services.mail");
        $mail->createEmail(
                    "Nova Senha",
                    array($user->getEmail()),
                    "UserBundle:Mail:newPassword.html.twig",
                    array("user" => $user->toArray(), "newPassword" => $newPassword)
                );
        $mail->sendEmail();
    }
    
    public function logger($action, $observation = null)
    {
       $this->get("epsoftware.user.logger")->logger($this->local, $action, $this->getUser(), $observation); 
    }
}
