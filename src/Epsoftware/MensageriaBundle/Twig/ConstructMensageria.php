<?php

namespace Epsoftware\MensageriaBundle\Twig;

use Doctrine\ORM\EntityManager;
use Twig_Environment;


/**
 * Esta classe rendereiza os menus da aplicação
 * De acordo com usuario logado
 *
 * @author tom
 */
class ConstructMensageria extends \Twig_Extension
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
        return "ConstructMensageria";
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('mensageria_widget', array($this, 'getMensageria')),
        );
    }
        
    public function getMensageria()
    {
        if($this->twig):
            return $this->twig->render("MensageriaBundle:Mensageria:mensageria.html.twig", array());
        endif;
        
        throw new \Exception('Erro ao tentar carregar a mensageria, renderizador $this->twig não está setado');
    }
}
