<?php

namespace Epsoftware\AddressBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\AddressBundle\Entity\Categoria;


class LoadCategoriaData extends AbstractFixture implements OrderedFixtureInterface
{
    
    private $categorias = array('Caixa Postal'=>'bg-aqua-gradient','Comercial'=> 'bg-green-gradient','Residencial'=>'bg-light-blue-active','Outros'=>'bg-danger');
    
    public function load(ObjectManager $manager)
    {
        foreach ($this->categorias as $categoria => $bgColor):
            $this->createCategoria($manager, $categoria, $bgColor);
        endforeach;
        $manager->flush();
    }
    
    private function createCategoria(ObjectManager $manager, $categoria, $bgColor)
    {
        $categoriaOb = new Categoria();
        $categoriaOb->setCategoria($categoria)->setBgColor($bgColor);
        $manager->persist($categoriaOb);
    }
    
    public function getOrder()
    {
        return 100;
    }
}
