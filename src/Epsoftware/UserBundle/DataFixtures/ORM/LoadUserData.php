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
        
        $userAdmin->addPermission($this->getReference("permission-ROLE_SUPER_ADMIN"));
        
        $userAdmin->setAgree(true);
        $userAdmin->setIsEnable(true);
        $userAdmin->setIsAccountNonExpired(true);
        $userAdmin->setIsAccountNonLocked(true);
        $userAdmin->setIsCredentialNonExpired(true);
        
        $user = new User();
        $user->setEmail("eric.projetos@gmail.com");
        $user->setUsername("eric");
        $user->setPlainPassword("Tom123");
        
        $user->addPermission($this->getReference("permission-ROLE_USER"));
        
        $user->setAgree(true);
        $user->setIsEnable(true);
        $user->setIsAccountNonExpired(true);
        $user->setIsAccountNonLocked(true);
        $user->setIsCredentialNonExpired(true);
        
        $manager->persist($userAdmin);
        $manager->persist($user);
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 20;
    }
}
