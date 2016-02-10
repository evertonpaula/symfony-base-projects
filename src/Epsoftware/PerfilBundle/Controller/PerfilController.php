<?php

namespace Epsoftware\PerfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\PerfilBundle\Entity\Setting; 
use Epsoftware\PerfilBundle\Entity\Profile;
use Epsoftware\PerfilBundle\Form\SettingFormType;
use Epsoftware\PerfilBundle\Form\ProfileFormType;
use Epsoftware\UserBundle\Form\UpdateUserFormType;


class PerfilController extends Controller
{
    /**
     * @Route("/admin/dash/profile", name="user_profile")
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @Template()
     */
    public function profileAction()
    {
        $profile = $this->getUser()->getProfile();
        
        if( $profile === null):
            $profile = new Profile();
            $setting = new Setting();
        else:
            $setting = $profile->getSetting();
        endif;
               
        $formSetting = $this->createForm(SettingFormType::class, $setting, array("action" => $this->generateUrl("profile_setting_save")));
        $formProfile = $this->createForm(ProfileFormType::class, $profile, array("action" => $this->generateUrl("profile_new")));
        $formUser = $this->createForm(UpdateUserFormType::class, $this->getUser(), array("action" => $this->generateUrl("profile_user_update")));
        
        return array('form_conf' => $formSetting->createView(), 'form_profile' => $formProfile->createView(), 'form_user' => $formUser->createView());
    }
    
    /**
     * @Route("/admin/profile/new", name="profile_new")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
    */
    public function newProfileAction(Request $request)
    {
        $profile = $this->getUser()->getProfile();
        $firstime = false;
            
        if( $profile === null):
            $profile = new Profile();
            $firstime = true;
        endif;
        
        $form = $this->createForm(ProfileFormType::class, $profile);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $this->getUser()->setProfile($profile);
            $em->flush();
            
            if($firstime):
                return $this->get("epsoftware.response.json")->getInfo("Perfil criado com sucesso.");
            endif;
                
            return $this->get("epsoftware.response.json")->getSuccess("Perfil atualizado com sucesso.");
        endif;
        
        return $this->get("epsoftware.response.json")->getFormErrors($form);
    }
    
    /**
     * @Route("/admin/profile/setting/save", name="profile_setting_save")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function saveProfileSettingAction(Request $request)
    {
        $profile = $this->getUser()->getProfile();
        
        if( $profile === null):
            return $this->get("epsoftware.response.json")->getWarning("Aviso, você precisa preencher e salvar seu perfil antes de selecionar uma aparência.");
        endif;
        
        $setting = $profile->getSetting();
        
        if($setting === null):
            $setting = new Setting();
        endif;
        
        $form = $this->createForm(SettingFormType::class, $setting);
        $form->handleRequest($request);
        
        if ($form->isValid()):
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $profile->setSetting($setting);
            $em->persist($profile);
            $em->flush();
            return $this->get("epsoftware.response.json")->getSuccess("Aparência atualizada com sucesso.");
        endif;
        
        return $this->get("epsoftware.response.json")->getFormErrors($form);
    }
    
    /**
     * @Route("/admin/profile/user/update", name="profile_user_update")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function updateProfileUserAction(Request $request)
    {
        $user = $this->getUser();
        
        $form = $this->createForm(UpdateUserFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->get("epsoftware.response.json")->getSuccess("Dados de acesso atualizado com sucesso.");
        endif;
        
        return $this->get("epsoftware.response.json")->getFormErrors($form);
    }
    
    /**
     * @Route("/admin/profile/address/new", name="profile_address_new")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newProfileAddressAction(Request $request)
    {
        $profile = $this->getUser()->getProfile();
       
        if($profile):
            $request->request->add(array('object' => $profile));
            $path = $request->attributes->all();
            return $this->forward("AddressBundle:Address:newAddress", $path);
        endif;
            
        return $this->get("epsoftware.response.json")->getWarning("Antes de cadastrar um endereço  é preciso ter um perfil criado.");
        
    }
    
    /**
     * @Route("/admin/profile/address/map", name="profile_address_map")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function mapProfileAddressAction(Request $request)
    {
        $profile = $this->getUser()->getProfile();
       
        if($profile):
            $request->request->add(array('object' => $profile));
            $path = $request->attributes->all();
            return $this->forward("AddressBundle:Address:mapAddress", $path);
        endif;
            
        return $this->get("epsoftware.response.json")->getWarning("Antes de visualizar endereços é preciso ter um perfil criado.");
        
    }
}
