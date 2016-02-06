<?php

namespace Epsoftware\PerfilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\PerfilBundle\Entity\Genero;


class LoadGeneroData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    private $generos = array('Masculino', 'Feminino');
    
    public function load(ObjectManager $manager)
    {
        foreach ($this->generos as $genero):
            $this->createGenero($manager, $genero);
        endforeach;
        $manager->flush();
    }
    
    private function createGenero(ObjectManager $manager, $genero)
    {
        $generoOb = new Genero();
        $generoOb->setGenero($genero);
        $manager->persist($generoOb);
    }
    
    public function getOrder()
    {
        return 50;
    }
}
