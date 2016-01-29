<?php

namespace Epsoftware\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Epsoftware\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setEmail("everton.projetos@gmail.com");
        $userAdmin->setUsername("tom");
        $userAdmin->setPlainPassword("Tom123");
        
        $userAdmin->addPermission($this->getReference("permission-ROLE_ADMIN"));
        $userAdmin->addPermission($this->getReference("permission-ROLE_USER"));
        
        $userAdmin->setAgree(true);
        $userAdmin->setIsEnable(false);
        $userAdmin->setIsAccountNonExpired(true);
        $userAdmin->setIsAccountNonLocked(true);
        $userAdmin->setIsCredentialNonExpired(true);
        
        $manager->persist($userAdmin);
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 20;
    }
}
