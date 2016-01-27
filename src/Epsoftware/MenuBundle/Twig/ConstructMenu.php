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
            new \Twig_SimpleFunction('menu_side', array($this, 'getMenuSide')),
        );
    }
        
    public function getMenuSide()
    {
        if($this->twig):
            return $this->twig->render("MenuBundle:Menu:menu_side.html.twig", array("name" => "everton"));
        endif;
        
        throw new \Exception('Erro ao tentar carregar o menu principal, renderizador $this->twig não está setado');
    }
}
