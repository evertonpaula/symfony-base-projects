<?php

namespace Epsoftware\AddressBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;


class LoadCidadeData extends AbstractFixture implements OrderedFixtureInterface
{
    
    private $path = 'src/Epsoftware/AddressBundle/Resources/sql';
    private $filename = 'base_address_cidade.sql';
    
    public function load(ObjectManager $manager)
    {
        $finder = new Finder();
        $finder->in($this->path);
        $finder->name($this->filename);
        
        foreach ($finder as $file):
            $sql = $file->getContents();
            $stmt = $manager->getConnection()->prepare($sql);  // Execute native SQL
            $stmt->execute();
            $manager->flush();
        endforeach;
    }
    
    public function getOrder()
    {
        return 90;
    }
}
