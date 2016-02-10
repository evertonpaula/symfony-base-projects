<?php

namespace Epsoftware\AddressBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Epsoftware\UserBundle\Services\EncryptsBaseCode;
use Epsoftware\AddressBundle\Entity\Cidade;
use Epsoftware\AddressBundle\Entity\Estado;
use Epsoftware\AddressBundle\Entity\Address;
use Epsoftware\AddressBundle\Form\AddressFormType;
use Epsoftware\AddressBundle\Services\ResponseJsonMap;

class AddressController extends Controller
{
    /**
     * @Route("/admin/address/edit/{id}", name="edit_address", defaults={"id":"null"})
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
    */
    public function editAddressAction($id, Request $request)
    {
        $descrypt = new EncryptsBaseCode();
        $url = $this->generateUrl("edit_address", array('id' => $id));
        
        $address = $this->getDoctrine()->getRepository(Address::class)->find($descrypt->descrypt($id));
        
        if(!$address):
            return $this->get("epsoftware.response.json")->getWarning("Ocorreu algum problema para identificação do endereço a ser editado.");
        endif;
        
        $form = $this->createForm(AddressFormType::class, $address, array("action" => $url, "attr"=> array("class" => "addressEdit")));
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()):
            if($form->isValid()):
                $em = $this->getDoctrine()->getManager();                                               
                $em->persist($address);
                $em->flush();
                $parameters = $this->renderView("AddressBundle:Address:listAddress.html.twig", array('address' => array($address)));
                return $this->get("epsoftware.response.json")->getSuccess("Endereço atualizado com sucesso.", array('view'=>$parameters));
            else:
                return $this->get("epsoftware.response.json")->getFormErrors($form);
            endif;
        endif;
        
        return $this->render("AddressBundle:Forms:address.html.twig", array("form_address" => $form->createView()));
    }
    
    /**
     * @Route("/admin/address/new", name="new_address" )
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
    */
    public function newAddressAction(Request $request)
    {
        $object = $request->get("object");
        $address = new Address();
        $form = $this->createForm(AddressFormType::class, $address);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()):
            $em = $this->getDoctrine()->getManager();                                               
            $em->persist($address);
            $object->addAddress($address);
            $em->persist($object);
            $em->flush();
            $parameters = $this->renderView("AddressBundle:Address:listAddress.html.twig", array('address' => array($address)));
            return $this->get("epsoftware.response.json")->getSuccess("Endereço adicionado com sucesso.", array('view' => $parameters));
        endif;

        return $this->get("epsoftware.response.json")->getFormErrors($form);
    }
    
    /**
     * @Route("/admin/address/new", name="new_address" )
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
    */
    public function mapAddressAction(Request $request)
    {
        $object = $request->get("object");
        $jsonMap = new ResponseJsonMap();
        return $jsonMap->getJsonMap($object);
    }
    
    /**
     * @Route("/admin/address/delete/{id}", name="delete_address" )
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
    */
    public function deleteAddressAction($id)
    {
        $descrypt = new EncryptsBaseCode();
        $address = $this->getDoctrine()->getRepository(Address::class)->find($descrypt->descrypt($id));
        
        if($address):
            $em = $this->getDoctrine()->getManager();                                               
            $em->remove($address);
            $em->flush();
            return $this->get("epsoftware.response.json")->getSuccess("Endereço deletado com sucesso.");
        endif;
        
        return $this->get("epsoftware.response.json")->getErrors("Erro ao tentar deletar endereço.");
    }
    
    
    /**
     * @Route("/admin/address/get/cities", name="get_cities")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function getCitiesAction(Request $request)
    {
        $id = (int)$request->get('address_form')['estado'];
        
        if(!$id):
            return;
        endif;
       
        $cidades = $this->getDoctrine()->getRepository(Cidade::class)->findBy(array('estado' => $id));
        
        return array("cidades" => $cidades);
    }
    
    /**
     * @Route("/admin/address/get/states", name="get_states")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function getStatesAction(Request $request)
    {
        $id = (int)$request->get('address_form')['pais'];
        
        if(!$id):
            return;
        endif;
       
        $estados = $this->getDoctrine()->getRepository(Estado::class)->findBy(array('pais' => $id));
        
        return array("estados" => $estados);
    }
    
    
}
