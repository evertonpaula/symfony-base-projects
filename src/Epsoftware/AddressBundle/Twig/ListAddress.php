<?php

namespace Epsoftware\AddressBundle\Twig;

use Doctrine\ORM\EntityManager;
use Twig_Environment;
use Epsoftware\AddressBundle\Entity\Address;
use Epsoftware\PerfilBundle\Entity\Profile;

/**
 * Esta classe rendereiza os lista de endereços
 * De acordo com usuario logado
 *
 * @author tom
 */
class ListAddress extends \Twig_Extension
{
    
    /**
     * EntityManager
     * @var Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     * Twig
     * @var Twig_Environment
     */
    private $twig;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function setTwigEnvironment(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
        
    public function getName()
    {
        return "ListAddress";
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('address', array($this, 'listAddress')),
        );
    }
        
    public function listAddress($obejct)
    {
        
        if($obejct instanceof Profile && $this->twig):
            return $this->twig->render("AddressBundle:Address:listAddress.html.twig", array("address" => $obejct->getAddress()->toArray()));
        endif;
        
        throw new \Exception('Erro ao tentar carregar o lista de endereços, renderizador $this->twig não está setado');
    }
}
