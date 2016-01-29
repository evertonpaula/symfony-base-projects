<?php

namespace Epsoftware\PerfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PerfilController extends Controller
{
    /**
     * @Route("/admin/dash/profile", name="user_profile")
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function profileAction()
    {
        return array();
    }
}
