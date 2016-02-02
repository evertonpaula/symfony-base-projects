<?php

namespace Epsoftware\PerfilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\PerfilBundle\Entity\Profissao;


class LoadProfissaoData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    public function load(ObjectManager $manager)
    {
        $manager->flush();
    }
    
    private function createProfissao(ObjectManager $manager, $profissao)
    {
        $profissaoOb = new Profissao();
        $profissaoOb->setProfissao($profissao);
        $manager->persist($profissaoOb);
    }
    
    public function getOrder()
    {
        return 50;
    }
}
