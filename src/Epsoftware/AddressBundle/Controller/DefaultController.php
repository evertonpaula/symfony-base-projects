<?php

namespace Epsoftware\AddressBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('AddressBundle:Default:index.html.twig');
    }
}
