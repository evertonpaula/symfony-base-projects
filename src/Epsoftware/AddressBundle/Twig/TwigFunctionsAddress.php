<?php

namespace Epsoftware\AddressBundle\Twig;

use Doctrine\ORM\EntityManager;
use Twig_Environment;
use Epsoftware\PerfilBundle\Entity\Profile;
use Symfony\Component\Form\FormFactory;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Epsoftware\AddressBundle\Form\AddressFormType;
use Epsoftware\AddressBundle\Entity\Address;

/**
 * Esta classe rendereiza os lista de endereços
 * De acordo com usuario logado
 *
 * @author tom
 */
class TwigFunctionsAddress extends \Twig_Extension
{
    
    /**
     * EntityManager
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     * Twig
     * @var \Twig_Environment
     */
    private $twig;
    
    /**
     *
     * @var \Symfony\Component\Form\FormFactory
     */
    private $formFactory;
    
    /**
     *
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router 
     */
    private $router;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function setTwigEnvironment(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }
    
    public function setRouter(Router $router){
        $this->router = $router;
    }
    
    public function getName()
    {
        return "TwigFunctionsAddress";
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('listAddress', array($this, 'listAddress')),
            new \Twig_SimpleFunction('address', array($this, 'getTemplateAddress')),
            new \Twig_SimpleFunction('getFormNewAddress', array($this, 'getFormNewAddress')),
        );
    }
    
    public function getTemplateAddress($object)
    {
        return $this->twig->render("AddressBundle:Template:template.html.twig", array("object" => $object));
    }
    
    public function getFormNewAddress($object)
    {
        $url = null;
        $address = new Address();
    
        if($object instanceof Profile):
            $url = $this->router->generate('profile_address_new');
        endif;
        
        $form = $this->formFactory->create(AddressFormType::class, $address, array("action" => $url, "attr"=> array("class" => "addressAdd")));
        return $this->twig->render("AddressBundle:Forms:address.html.twig", array('form_address' => $form->createView()));
    }
    
    public function listAddress($object)
    {
        if($this->twig):
            return $this->twig->render("AddressBundle:Address:listAddress.html.twig", array("address" => $object->getAddress()->toArray()));
        endif;
        
        throw new \Exception('Erro ao tentar carregar o lista de endereços, renderizador $this->twig não está setado');
    }
}
