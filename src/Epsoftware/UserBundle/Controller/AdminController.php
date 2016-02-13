<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\UserBundle\Services\EncryptsBaseCode;
use Epsoftware\UserBundle\Entity\User;
use Epsoftware\UserBundle\Ajax\UserDataTable;
use Epsoftware\UserBundle\Form\AdminUserAccess;


class AdminController extends Controller
{
     /**
     * @Route("/admin/dash/users", name="user_admin")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function usersAction()
    {
        return array();
    }
    
    /**
     * @Route("/api/data/table/users", name="user_admin_data_table")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function dataTableUsersAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $extra = array( 
                'url_profile' => $this->generateUrl("user_admin_get_profile"),
                'url_delete' =>  $this->generateUrl("user_admin_delete"),
                'url_permissions' => $this->generateUrl("user_admin_edit_access_user"),
                'url_logs' => $this->generateUrl("user_admin_delete")
            );
        $api = new UserDataTable($users);
        $api->setSuccess("Usuário carregados com sucesso.");
        return $api->setSource("users", $extra);
    }
    
    /**
     * @Route("/admin/dash/users/delete/{id}", name="user_admin_delete", defaults={"id":"null"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function deleteUserAction($id)
    {
        $descrypt = new EncryptsBaseCode();
        $user = $this->getDoctrine()->getRepository(User::class)->find($descrypt->descrypt($id));
        
        if($user):
            if($user->getId() !== $this->getUser()->getId()):
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
                return $this->get("epsoftware.response.json")->getSuccess("Usuário deletado com sucesso.");
            endif;
            return $this->get("epsoftware.response.json")->getWarning("Você não pode se auto deletar.");
        endif;
        return $this->get("epsoftware.response.json")->getErrors("Erro ao tentar deletar usuário, não foi possivel encontrar o usuário a ser deletado.");
    }
    
    /**
     * @Route("/admin/dash/users/profile/show/{id}", name="user_admin_get_profile", defaults={"id":"null"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function showProfilelUserAction($id)
    {
        $descrypt = new EncryptsBaseCode();
        $user = $this->getDoctrine()->getRepository(User::class)->find($descrypt->descrypt($id));
        $profile = $user->getProfile();
        
        if($profile):
           return $this->render("PerfilBundle:Perfil:profile.ready.html.twig", array("profile" => $profile));
        endif;
        
        return $this->get("epsoftware.response.json")->getErrors("Erro ao tentar mostrar o perfil, não foi possível encontrar o perfil.");
    }
    
    /**
     * @Route("/admin/dash/users/access/edit/{id}", name="user_admin_edit_access_user", defaults={"id":"null"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     * @Template()
    */
    public function editUserAccessAction($id, Request $request)
    {
        $descrypt = new EncryptsBaseCode();
        $myId = $this->getUser()->getId();
        $idDescrypt = $descrypt->descrypt($id);
        if($myId != $idDescrypt):
            $user = $this->getDoctrine()->getRepository(User::class)->find($idDescrypt);
            $form = $this->createForm(AdminUserAccess::class, $user, array('action'=> $this->generateUrl("user_admin_edit_access_user",array("id"=>$id))));
            $form->handleRequest($request);
            if($form->isSubmitted()):
                if($form->isValid()):
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    return $this->get("epsoftware.response.json")->getSuccess("Dados de Acesso alterados com sucesso.");
                else:
                    return $this->get("epsoftware.response.json")->getFormErrors($form);
                endif;
            else:
                return array("form_user_access" => $form->createView(), "id" => $id);
            endif;
        endif;
        return $this->get("epsoftware.response.json")->getWarning("Você não pode alterar os próprios dados de acesso");
    }
    
    /**
     * @Route("/refactor/password/user/{id}", name="user_refactor_passowrd", defaults={"id":"null"})
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @Template()
     */
    public function refactorPasswortdUserAction($id)
    {
        $descrypt = new EncryptsBaseCode();
        $idDescrypt = $descrypt->descrypt($id);
        
        $user = $this->getDoctrine()->getRepository(User::class)->find($idDescrypt);
        
        if($user):
            $newPassword = "N". base_convert(sha1(uniqid(mt_rand(), true)), 8, 36) . "P";
            $user->setPlainPassword($newPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->sendEmail($user, $newPassword);
            return $this->get("epsoftware.response.json")->getSuccess("Nova senha enviada com sucesso {$newPassword}");
        endif;
        return $this->get("epsoftware.response.json")->getErrors("Não foi possível identificar usuário para geração de nova senha.");
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
                    "epsoftware@epsoftware.com.br",
                    array($user->getEmail()),
                    "UserBundle:Mail:newPassword.html.twig",
                    array("user" => $user->toArray(), "newPassword" => $newPassword)
                );
        $mail->sendEmail();
    }
    
    
    
}
