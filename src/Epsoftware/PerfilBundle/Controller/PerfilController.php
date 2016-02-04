<?php

namespace Epsoftware\PerfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        
        $formSetting = $this->createForm(SettingFormType::class, $setting, array("action" => $this->generateUrl("user_setting_profile_ajax")));
        $formProfile = $this->createForm(ProfileFormType::class, $profile, array("action" => $this->generateUrl("user_profile_ajax")));
        $formUser = $this->createForm(UpdateUserFormType::class, $this->getUser(), array("action" => $this->generateUrl("user_update_ajax")));
        return array('form_conf' => $formSetting->createView(), 'form_profile' => $formProfile->createView(), 'form_user' => $formUser->createView());
    }
}
