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
use Epsoftware\UserBundle\Entity\Logger;
use Epsoftware\UserBundle\Ajax\UserDataTable;
use Epsoftware\UserBundle\Ajax\LogsDataTable;
use Epsoftware\UserBundle\Form\AdminUserAccess;
use Epsoftware\UserBundle\Form\UserPermissionsFormType;


class AdminController extends Controller
{
     
    private $local = "Controle Usuário";
    
    /**
     * @Route("/admin/dash/users", name="user_admin")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function usersAction()
    {
        $action = "Acessou área administrativa de usuários";
        $this->logger($action);
        return array();
    }
    
    /**
     * @Route("/admin/dash/logs/show", name="logs_show")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function logAction()
    {
        $action = "Visualizar Logs";
        $this->logger($action, "Entrou na área de visualização de logs");
        return array();
    }
    
    /**
     * @Route("/admin/dash/users/logs/show/{id}", name="user_logs_show", defaults={"id":"0"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function logsUserAction($id)
    {
        $action = "Visualizar Logs";
        $this->logger($action, "Entrou na área de visualização de logs por usuário");
        return array("id" => $id);
    }
    
    /**
     * @Route("/api/data/table/logs/{id}", name="logs_admin_data_table", defaults={"id" : "null"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     * @Template()
     */
    public function dataTableLogsAction($id)
    {
        if($id !== null && $id != "null"):
            $descrypt = new EncryptsBaseCode();
            $logs =  $this->getDoctrine()->getRepository(Logger::class)->getLogs($descrypt->descrypt($id));
        else:
            $logs = $this->getDoctrine()->getRepository(Logger::class)->getLogs();
        endif;
        $api = new LogsDataTable($logs);
        $api->setSuccess("Logs carregados com sucesso.");
        return $api->setSource("logs");
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
                'url_logs' => $this->generateUrl("user_logs_show")
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
        $action = "Exclusão de usuário";
        
        $descrypt = new EncryptsBaseCode();
        $user = $this->getDoctrine()->getRepository(User::class)->find($descrypt->descrypt($id));
        $username = $user->getUsername();
        if($user):
            if($user->getId() !== $this->getUser()->getId()):
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
                $this->logger($action, "Deletou {$username}");
                return $this->get("epsoftware.response.json")->getSuccess("Usuário deletado com sucesso.");
            endif;
            $this->logger($action, "Tentou auto delete");
            return $this->get("epsoftware.response.json")->getWarning("Você não pode se auto deletar.");
        endif;
        $this->logger($action, "Falha na tentativa de delete de {$username}");
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
        $action = "Visualizar info. usuário";
        
        $descrypt = new EncryptsBaseCode();
        $user = $this->getDoctrine()->getRepository(User::class)->find($descrypt->descrypt($id));
        $profile = $user->getProfile();
        
        if($profile):
           $this->logger( $action, "Abriu visualização de {$user->getUsername()}");
           return $this->render("PerfilBundle:Perfil:profile.ready.html.twig", array("profile" => $profile));
        endif;
        $this->logger($action, "Falha ao tentar abrir visualização de {$user->getUsername()}");
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
        $action = "Editar acesso do usuário";
        
        $descrypt = new EncryptsBaseCode();
        $myId = $this->getUser()->getId();
        $idDescrypt = $descrypt->descrypt($id);
        if($myId != $idDescrypt):
            $user = $this->getDoctrine()->getRepository(User::class)->find($idDescrypt);
            $form = $this->createForm(AdminUserAccess::class, $user, array('action'=> $this->generateUrl("user_admin_edit_access_user",array("id"=>$id))));
            $formPermission = $this->createForm(UserPermissionsFormType::class, $user, array('action'=> $this->generateUrl("user_admin_update_permission_user",array("id"=>$id))));
            $form->handleRequest($request);
            if($form->isSubmitted()):
                if($form->isValid()):
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $this->logger($action, "Auterou dados de acesso de {$user->getUsername()}");
                    return $this->get("epsoftware.response.json")->getSuccess("Dados de Acesso alterados com sucesso.");
                else:
                    $this->logger($action, "Falha ao alterar dados de acesso de {$user->getUsername()}");
                    return $this->get("epsoftware.response.json")->getFormErrors($form);
                endif;
            else:
                return array("form_user_access" => $form->createView(), "id" => $id, "form_permission" => $formPermission->createView());
            endif;
        endif;
        return $this->get("epsoftware.response.json")->getWarning("Você não pode alterar os próprios dados de acesso");
    }
    
    /**
     * @Route("/admin/dash/user/permission/update/{id}", name="user_admin_update_permission_user")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET","POST"})
    */
    public function updatePermissionUser($id, Request $request)
    {
        $action = "Editar permissões do usuário";
        
        $descrypt = new EncryptsBaseCode();
        $user = $this->getDoctrine()->getRepository(User::class)->find($descrypt->descrypt($id));
        $form = $this->createForm(UserPermissionsFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->logger($action,"Auterou permissões de {$user->getUsername()}");
            return $this->get("epsoftware.response.json")->getSuccess("Dados de Acesso alterados com sucesso.");
        endif;
        
        return $this->get("epsoftware.response.json")->getFormErrors($form);
    }
    
    
    
    /**
     * @Route("/refactor/password/user/{id}", name="user_refactor_passowrd", defaults={"id":"null"})
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @Template()
     */
    public function refactorPasswortdUserAction($id)
    {
        $action = "Envio de nova senha";
        
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
            $this->logger($action, "Enviou nova senha para {$user->getEmail()}");
            return $this->get("epsoftware.response.json")->getSuccess("Nova senha enviada com sucesso");
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
    
    public function logger($action, $observation = null)
    {
       $this->get("epsoftware.user.logger")->logger($this->local, $action, $this->getUser(), $observation); 
    }
    
}
