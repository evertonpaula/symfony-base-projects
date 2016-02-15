<?php

namespace Epsoftware\MenuBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\MenuBundle\Entity\Forms;


class LoadFormsData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    public function load(ObjectManager $manager)
    {
        //$manager->persist($this->createForm("User Controle", "Controle de acesso e ações do usuário", "Insert, Delete, Edit", , $permission));
        //$manager->flush();
    }
    
    private function createForm($name, $description, $action, $path, $permission)
    {
        $form = new Forms();
        $form->setName($name)
             ->setDescription($description)
             ->setAction($action)
             ->setPath($path);
        $form->addPermission($permission);
        return $form;
    }
    
    
    public function getOrder()
    {
        return 11;
    }
}
