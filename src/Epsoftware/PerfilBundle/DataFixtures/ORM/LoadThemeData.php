<?php

namespace Epsoftware\PerfilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\PerfilBundle\Entity\Theme;


class LoadThemeData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    private $skins = array('skin-blue','skin-blue-light','skin-yellow','skin-yellow-light','skin-green','skin-green-light',
                            'skin-purple','skin-purple-light', 'skin-red','skin-red-light','skin-black','skin-black-light' );
    
    private $icon = '<i class="fa fa-desktop"></i>';

    private $legendes = array('azul','azul e branco','amarelo','amarelo e branco','verde','verde e branco',
                            'roxo','roxo e branco', 'vermelho','vermelho e branco','preto','preto e branco' );
    
    
    public function load(ObjectManager $manager)
    {
        for ($i = 0 ; $i < count($this->skins); $i++):
            $this->createSetting($manager, $this->skins[$i], $this->legendes[$i] );
        endfor;
        $manager->flush();
    }
    
    private function createSetting(ObjectManager $manager, $skin, $legend)
    {
        $theme = new Theme();
        $theme->setSkin($skin);
        $theme->setIcon($this->icon);
        $theme->setLegend($legend);
        $manager->persist($theme);
    }
    
    public function getOrder()
    {
        return 40;
    }
}
