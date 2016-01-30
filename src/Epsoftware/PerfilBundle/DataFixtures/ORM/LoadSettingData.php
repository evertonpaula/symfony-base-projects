<?php

namespace Epsoftware\PerfilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\PerfilBundle\Entity\Setting;


class LoadSettingData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    private $themes = array('skin-blue','skin-blue-light','skin-yellow','skin-yellow-light','skin-green','skin-green-light',
                            'skin-purple','skin-purple-light', 'skin-red','skin-red-light','skin-black','skin-black-light' );
    
    public function load(ObjectManager $manager)
    {
        foreach ($this->themes as $theme):
            $this->createSetting($manager, $theme);
        endforeach;
        $manager->flush();
    }
    
    private function createSetting(ObjectManager $manager, $theme)
    {
        $setting = new Setting();
        $setting->setTheme($theme);
        $manager->persist($setting);
    }
    

    public function getOrder()
    {
        return 40;
    }
}
