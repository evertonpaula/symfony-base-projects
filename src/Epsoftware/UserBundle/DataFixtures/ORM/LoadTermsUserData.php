<?php

namespace Epsoftware\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\UserBundle\Entity\TermsUser;
use Symfony\Component\Finder\Finder;

class LoadTermsUserData extends AbstractFixture implements OrderedFixtureInterface 
{
    public function load(ObjectManager $manager)
    {
        $descrption = $this->readFile();
        $this->createTerms($manager, "REGRAS E TERMOS DE USO", $descrption);
        $manager->flush();
    }
    
    private function createTerms(ObjectManager $manager, $title, $descrption)
    {
        $objTerms = new TermsUser();
        $objTerms->setTitle($title);
        $objTerms->setDescription($descrption);
        $manager->persist($objTerms);
    }
    
    private function readFile()
    {
        $finder = new Finder();
        $finder->files()->in('src/Epsoftware/UserBundle/Resources/terms');

        foreach ($finder as $file) {
            $contents = $file->getContents();
        }
        return $contents;
    }
  
    public function getOrder()
    {
        return 30;
    }
}
