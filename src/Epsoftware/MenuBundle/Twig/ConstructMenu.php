<?php

namespace Epsoftware\MenuBundle\Twig;

use Doctrine\ORM\EntityManager;
use Twig_Environment;
use Epsoftware\MenuBundle\Entity\FirstMenu;
use Doctrine\Common\Collections\Collection;


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
            new \Twig_SimpleFunction('permission', array($this, 'inArray')),
            new \Twig_SimpleFunction('listarMenus', array($this, 'listMenus')),
        );
    }
        
    public function getMenuAside()
    {
        if($this->twig):
            $menu = $this->em->getRepository(FirstMenu::class)->findAll();
            return $this->twig->render("MenuBundle:Menu:aside.html.twig", array("menus"=> $menu));
        endif;
        
        throw new \Exception('Erro ao tentar carregar o menu principal, renderizador $this->twig não está setado');
    }
    
    public function inArray(Collection $roles, Collection $required)
    {
        if($required->isEmpty()):
            return true;
        endif;
        
        foreach ($required as $req):
            foreach ($roles as $role):
                if($req->getRole() === $role->getRole()):
                    return true;
                endif;
            endforeach;
        endforeach;
        
                
        return false;
    }
    
    public function listMenus(){
       
        if($this->twig):
            $menu = $this->em->getRepository(FirstMenu::class)->findAll();
            return $this->twig->render("MenuBundle:Menu:listMenus.html.twig", array("menus"=> $menu));
        endif;
        
        throw new \Exception('Erro ao tentar carregar o menu principal, renderizador $this->twig não está setado');
    }
}
