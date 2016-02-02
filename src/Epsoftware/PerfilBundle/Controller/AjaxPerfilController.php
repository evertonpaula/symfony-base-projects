<?php

namespace Epsoftware\PerfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Epsoftware\PerfilBundle\Entity\Profile;
use Epsoftware\PerfilBundle\Entity\Setting;
use Epsoftware\PerfilBundle\Form\ProfileFormType;
use Epsoftware\PerfilBundle\Form\SettingFormType;


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
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        if ($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $this->getUser()->setProfile($profile);
            $em->flush();
            $output = array('success' => true, 'mensagem' => 'Sucesso ao inserir perfil');
            $response->setContent(json_encode($output));
            return $response;
        endif;
        
        $output = array('error' => true, 'form_error');
        $response->setContent(json_encode($output));
        return $response;
    }
    
    
     /**
     * @Route("/ajax/setting/profile", name="user_setting_profile_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function ajaxSettingProfileAction(Request $request)
    {
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        $profile = $this->getUser()->getProfile();
        
        if( $profile === null):
            $output = array('error' => true, 'form_error');
            $response->setContent(json_encode($output));
            return $response;
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
            $output = array('success' => true, 'mensagem' => 'Sucesso ao inserir perfil');
            $response->setContent(json_encode($output));
            return $response;
        endif;
        
        $output = array('error' => true, 'form_error');
        $response->setContent(json_encode($output));
        return $response;
    }
    
}
