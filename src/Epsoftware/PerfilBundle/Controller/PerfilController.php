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
        $setting = new Setting();
        $formSetting = $this->createForm(SettingFormType::class, $setting, array("action" => $this->generateUrl("homepage")));
        
        $profile = new Profile();
        $formProfile = $this->createForm(ProfileFormType::class, $profile, array("action" => $this->generateUrl("user_profile_ajax")));
        return array('form_conf' => $formSetting->createView(), 'form_profile' => $formProfile->createView());
    }
}
