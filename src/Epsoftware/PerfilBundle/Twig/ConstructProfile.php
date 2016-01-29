<?php

namespace Epsoftware\PerfilBundle\Twig;

use Doctrine\ORM\EntityManager;
use Twig_Environment;


/**
 * Esta classe rendereiza os menus da aplicação
 * De acordo com usuario logado
 *
 * @author tom
 */
class ConstructProfile extends \Twig_Extension
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
        return "ConstructProfile";
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('profile_widget', array($this, 'getProfile')),
        );
    }
        
    public function getProfile()
    {
        if($this->twig):
            return $this->twig->render("PerfilBundle:Perfil:profile_widget.html.twig", array());
        endif;
        
        throw new \Exception('Erro ao tentar carregar a profile, renderizador $this->twig não está setado');
    }
}
