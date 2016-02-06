<?php

namespace Epsoftware\AddressBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\AddressBundle\Entity\Cidade;
use Epsoftware\AddressBundle\Entity\Estado;
use Epsoftware\AddressBundle\Entity\Address;
use Epsoftware\AddressBundle\Form\AddressFormType;

class AddressController extends Controller
{
    /**
     * @Route("/ajax/edit/address/{id}", name="edit_address_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template()
    */
    public function editAddressAction($id, Request $request)
    {
        $address = $this->getDoctrine()->getRepository(Address::class)->find($id);
        $form = $this->createForm(AddressFormType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();                                               
            $em->persist($address);
            $em->flush();
            return $this->get("epsoftware.response.json")->getSuccess("Endereço atualizado com sucesso.");
        endif;
            
        return $this->get("epsoftware.response.json")->getErrors($form);

    }
    
    /**
     * @Route("/ajax/edit/address", name="form_edit_address_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template()
    */
    public function getFormEditAddressAction(Request $request)
    {
        if($request->get("id")):
            
            $url = $this->generateUrl("edit_address_ajax", array('id' => $request->get("id")));
            $address = $this->getDoctrine()->getRepository(Address::class)->find($request->get("id"));
            $form = $this->createForm(AddressFormType::class, $address, array("action" => $url, "attr"=> array("class" => "addressEdit")));
            
            return $this->render("AddressBundle:Forms:address.html.twig", array("form_address" => $form->createView()));
        endif;
    }
    
    /**
     * @Route("/ajax/cidades", name="get_cidades_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function getCidadesAjaxAction(Request $request)
    {
        $id = (int)$request->get('address_form')['estado'];
        
        if(!$id):
            return;
        endif;
       
        $cidades = $this->getDoctrine()->getRepository(Cidade::class)->findBy(array('estado' => $id));
        
        return array("cidades" => $cidades);
    }
    
    /**
     * @Route("/ajax/estados", name="get_estados_ajax")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function getEstadosAjaxAction(Request $request)
    {
        $id = (int)$request->get('address_form')['pais'];
        
        if(!$id):
            return;
        endif;
       
        $estados = $this->getDoctrine()->getRepository(Estado::class)->findBy(array('pais' => $id));
        
        return array("estados" => $estados);
    }
    
    
}
