<?php

namespace Epsoftware\MenuBundle\Twig;

use Doctrine\ORM\EntityManager;
use Twig_Environment;


/**
 * Esta classe rendereiza os menus da aplicação
 * De acordo com usuario logado
 *
 * @author tom
 */
class ConstructMenu extends \Twig_Extension
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
        return "ConstructMenu";
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('aside', array($this, 'getMenuAside')),
        );
    }
        
    public function getMenuAside()
    {
        if($this->twig):
            return $this->twig->render("MenuBundle:Menu:aside.html.twig", array("name" => "everton"));
        endif;
        
        throw new \Exception('Erro ao tentar carregar o menu principal, renderizador $this->twig não está setado');
    }
}
