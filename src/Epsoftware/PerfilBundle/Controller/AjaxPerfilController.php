<?php

namespace Epsoftware\PerfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Epsoftware\PerfilBundle\Entity\Profile;
use Epsoftware\PerfilBundle\Form\ProfileFormType;


class AjaxPerfilController extends Controller
{
    /**
     * @Route("/ajax/profile", name="user_profile_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function ajaxProfileAction(Request $request)
    {
        
        $profile = new Profile();
        $form = $this->createForm(ProfileFormType::class, $profile);
        $form->handleRequest($request);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        if ($form->isSubmitted() && $form->isValid()):
            $output = array('success' => true, 'mensagem' => 'Sucesso ao inserir perfil');
            $response->setContent(json_encode($output));
            return $response;
        endif;
        
        $output = array('error' => true, 'form_error');
        $response->setContent(json_encode($output));
        return $response;
    }
}
