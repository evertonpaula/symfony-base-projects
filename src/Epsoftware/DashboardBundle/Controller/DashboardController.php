<?php

namespace Epsoftware\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    private $local = "Dashboard";
    
    /**
     * @Route("/admin/dash/simple", name="dashboard")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     * 
     */
    public function dashboardAction()
    {
        $action = "Entrou na dashboard";
        
        if(!$this->getUser()->getProfile()):
            return $this->redirectToRoute("user_profile");
        endif;
       
        if(in_array("ROLE_SUPER_ADMIN",$this->getUser()->getRoles())):
            return $this->redirectToRoute("dashboard_admin");
        endif;
            
        return array();
    }
    
    /**
     * @Route("/admin/dash/", name="dashboard_admin")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     * 
     */
    public function dashboardAdminAction()
    {
        return array();
    }
    
    public function logger($action, $observation = null)
    {
       $this->get("epsoftware.user.logger")->logger($this->local, $action, $this->getUser(), $observation); 
    }
}