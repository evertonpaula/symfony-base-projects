<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\UserBundle\Form\UploadImageUser;
use Epsoftware\UserBundle\Entity\ImageUser;

class UserController extends Controller
{
     
    private $local = "Funções Gerais";
    
    /**
     * @Route("/admin/dash/users/upload/image/show", name="alter_image_user_show")
     * @Security("has_role('ROLE_USER')")
     * @Method({"POST"})
     * @Template()
     */
    public function uploadImageUserShowAction(Request $request)
    {
        $action = "Acessou área de troca de imagem de usuário";
        
        $image = $this->getUser()->getImage();
        if($image === null):
            $image = new ImageUser();
        endif;
        $form = $this->createForm(UploadImageUser::class, $image, array("action"=>$this->generateUrl("alter_image_user_edit")));
        $this->logger($action);
        return array("form_upload" => $form->createView());
    }
    
    /**
     * @Route("/admin/dash/users/upload/image/edit", name="alter_image_user_edit")
     * @Security("has_role('ROLE_USER')")
     * @Method({"POST"})
     */
    public function uploadImageUserEditAction(Request $request)
    {
        $action = "Editar imagem do usuário";
        
        $image = $this->getUser()->getImage();
        if($image === null):
            $image = new ImageUser();
        endif;
        $form = $this->createForm(UploadImageUser::class, $image);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        
        if($form->isSubmitted() && $form->isValid()):
            $user = $this->getUser();
            $user->setImage($image);
            $em->persist($image);
            $em->persist($user);
            $em->flush();
            $this->logger($action, "imagem alterada com sucesso");
            $dir = $this->container->get('router')->getContext()->getBaseUrl() . DIRECTORY_SEPARATOR . $image->getUploadDir() . DIRECTORY_SEPARATOR . $image->getPath();
            return $this->get("epsoftware.response.json")->getSuccess("Imagem de usuário atualizada com sucesso.", array("image"=> $dir));
        endif;
        
        return $this->get("epsoftware.response.json")->uploadGetErrors($form);
    }
    
    public function logger($action, $observation = null)
    {
       $this->get("epsoftware.user.logger")->logger($this->local, $action, $this->getUser(), $observation); 
    }
    
}
