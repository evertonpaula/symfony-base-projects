<?php

namespace Epsoftware\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Route("/admin/dash", name="dashboard")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     * 
     */
    public function dashboardAction()
    {
        return array();
    }
}