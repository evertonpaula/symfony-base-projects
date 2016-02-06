<?php

namespace Epsoftware\PerfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\PerfilBundle\Entity\Profile;
use Epsoftware\PerfilBundle\Entity\Setting;
use Epsoftware\AddressBundle\Entity\Address;
use Epsoftware\PerfilBundle\Form\ProfileFormType;
use Epsoftware\PerfilBundle\Form\SettingFormType;
use Epsoftware\UserBundle\Form\UpdateUserFormType;
use Epsoftware\AddressBundle\Form\AddressFormType;
use Epsoftware\AddressBundle\Entity\Estado;
use Epsoftware\AddressBundle\Entity\Cidade;

class AjaxPerfilController extends Controller
{
    /**
     * @Route("/ajax/profile", name="user_profile_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function ajaxProfileAction(Request $request)
    {
        $profile = $this->getUser()->getProfile();
    
        if( $profile === null):
            $profile = new Profile();
        endif;
        
        $form = $this->createForm(ProfileFormType::class, $profile);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $this->getUser()->setProfile($profile);
            $em->flush();
            return $this->get("epsoftware.response.json")->getSuccess("Dados do perfil inseridos com sucesso.");
        endif;
        
        return $this->get("epsoftware.response.json")->getErrors($form);
    }
    
    
    /**
     * @Route("/ajax/setting/profile", name="user_setting_profile_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function ajaxSettingProfileAction(Request $request)
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
        
        return $this->get("epsoftware.response.json")->getErrors($form);
    }
    
    /**
     * @Route("/ajax/user", name="user_update_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function ajaxUserAction(Request $request)
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
        
        return $this->get("epsoftware.response.json")->getErrors($form);
    }
    
    /**
     * @Route("/ajax/address/profile", name="address_profile_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function ajaxAddressProfileAction(Request $request)
    {
        $profile = $this->getUser()->getProfile();
        
        if( $profile === null):
            return $this->get("epsoftware.response.json")->getWarning("Aviso, você precisa preencher e salvar seu perfil antes de adicionar um endereço.");
        endif;
        
        $address = new Address();
        
        $form = $this->createForm(AddressFormType::class, $address);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();                                               
            $em->persist($address);
            $profile->addAddress($address);
            $em->persist($profile);
            $em->flush();
            return $this->get("epsoftware.response.json")->getSuccess("Endereço adicionado com sucesso.");
        endif;

        return $this->get("epsoftware.response.json")->getErrors($form);
    }
}
