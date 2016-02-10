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
use Epsoftware\PerfilBundle\Entity\Profile;

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
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return array("users" => $users);
    }
    
    /**
     * @Route("/admin/dash/users/delete", name="user_admin_delete")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"POST"})
     * @Template()
     */
    public function deleteUserAction(Request $request)
    {
        $descrypt = new EncryptsBaseCode();
        $id = $descrypt->descrypt($request->get("id"));
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        
        if($user):
            if($user->getId() !== $this->getUser()->getId()):
                $em = $this->getDoctrine()->getEntityManager();
                $em->remove($user);
                $em->flush();
                return $this->get("epsoftware.response.json")->getSuccess("Usuário deletado com sucesso.");
            endif;
            return $this->get("epsoftware.response.json")->getWarning("Você não pode se auto deletar.");
        endif;
        return $this->get("epsoftware.response.json")->getErrors("Erro ao tentar deletar usuário, não foi possivel encontrar o usuário a ser deletado.");
    }
    
    /**
     * @Route("/admin/dash/users/profile/show", name="user_admin_get_profile")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"POST"})
     * @Template()
     */
    public function showProfilelUserAction(Request $request)
    {
        $descrypt = new EncryptsBaseCode();
        $id = $descrypt->descrypt($request->get("id"));
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $profile = $user->getProfile();
        
        if($profile):
           return $this->render("PerfilBundle:Perfil:profile.ready.html.twig", array("profile" => $profile));
        endif;
        
        return $this->get("epsoftware.response.json")->getErrors("Erro ao tentar mostrar o perfil, não foi possível encontrar o perfil.");
    }
}
