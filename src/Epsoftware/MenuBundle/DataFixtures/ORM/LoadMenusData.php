<?php

namespace Epsoftware\MenuBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\MenuBundle\Entity\FirstMenu;
use Epsoftware\MenuBundle\Entity\SecondMenu;
use Epsoftware\MenuBundle\Entity\ThirdMenu;


class LoadMenusData extends AbstractFixture implements OrderedFixtureInterface 
{
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createFirstMenu("Dashboard", "fa fa-dashboard", "dashboard", $this->getReference("permission-ROLE_USER")));
        $manager->persist($this->createFirstMenu("Dashboard", "fa fa-dashboard", "dashboard_admin", $this->getReference("permission-ROLE_ADMIN")));
        
        $controleUser = $this->createFirstMenu("Controle Usuário", "fa fa-user-plus", null, false); 
        
        $manter_user =  $this->createSecondMenu("Manter usuários", "pull-left", "user_admin", $controleUser, $this->getReference("permission-ROLE_SUPER_ADMIN"));
        $manager->persist($manter_user);
        
        $logs = $this->createSecondMenu("Logs", "pull-left", "user_admin", $controleUser, $this->getReference("permission-ROLE_SUPER_ADMIN"));
        $manager->persist($logs);
        
        $manager->flush();
    }
    
    public function createFirstMenu($title, $icon, $path, $permission = false)
    {
        $menu = new FirstMenu();
        $menu->setTitle($title)
             ->setIcon($icon)
             ->setPath($path);
        if($permission !== false):
            $menu->addPermission($permission);
        endif;
        return $menu;
    }
    
    
    public function createSecondMenu($title, $icon, $path, FirstMenu $father = null, $permission = false)
    {
        $menu = new SecondMenu();
        $menu->setTitle($title)
             ->setIcon($icon)
             ->setPath($path);
        if($permission !== false):
            $menu->addPermission($permission);
        endif;
        
        if($father !== null):
            $this->addSubMenus($father, $menu);
            $menu->setFirstMenu($father);
        endif;
            
        return $menu;
    }
    
    public function createThirdMenu($title, $icon, $path, SecondMenu $father = null, $permission = false)
    {
        $menu = new ThirdMenu();
        $menu->setTitle($title)
             ->setIcon($icon)
             ->setPath($path);
        if($permission !== false):
            $menu->addPermission($permission);
        endif;
        
        if($father !== null):
            $this->addSubSubMenus($father, $menu);
            $menu->setFirstMenu($father);
        endif;
        
        return $menu;
    }
    
    private function addSubMenus($menuFather, $submenu)
    {
        $menuFather->addSecondMenu($submenu);
    }
    
    private function addSubSubMenus($menuFather, $submenu)
    {
        $menuFather->addSecondMenu($submenu);
    }
    
    public function getOrder()
    {
        return 12;
    }
}
