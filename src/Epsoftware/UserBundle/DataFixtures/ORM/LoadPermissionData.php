<?php

namespace Epsoftware\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\UserBundle\Entity\Permission;

class LoadPermissionData extends AbstractFixture implements OrderedFixtureInterface 
{
    public function load(ObjectManager $manager)
    {
        $this->createPermission($manager, "ROLE_SUPER_ADMIN");
        $this->createPermission($manager, "ROLE_ADMIN");
        $this->createPermission($manager, "ROLE_USER");
        $manager->flush();
    }
    
    private function createPermission(ObjectManager $manager, $permission)
    {
        $objPermission = new Permission();
        $objPermission->setRole($permission);
        $manager->persist($objPermission);
        $this->setReference("permission-{$permission}", $objPermission);
    }
  
    public function getOrder()
    {
        return 10;
    }
}
