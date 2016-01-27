<?php

namespace Epsoftware\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Epsoftware\UserBundle\Entity\TermsUser;

class TermsUserController extends Controller
{
    /**
     * @Route("/register/termos", name="termos_user")
     * @Method({"GET"})
     * @Template()
     */
    public function termsAction()
    {
        $terms = $this->getDoctrine()->getManager()->getRepository(TermsUser::class)->find(1);
        return array("terms" => $terms->toArray());
    }
    
}