<?php

namespace Epsoftware\SuccessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Epsoftware\SuccessBundle\Services\SuccessRegister;

class SuccessController extends Controller
{
    /**
     * @Route("/register/success", name="success_register")
     * @Template()
     * @Method({"GET", "POST"})
     */
    public function successRegisterAction()
    {
        $success = new SuccessRegister();
        return $success->getTwigParameters();
    }
    
    
    
}
