<?php

namespace Epsoftware\PerfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\PerfilBundle\Entity\Profile;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity(repositoryClass="Epsoftware\PerfilBundle\Repository\SettingRepository")
 */
class Setting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255)
     */
    private $theme;

    /**
     * @var \Epsoftware\PerfilBundle\Entity\Profile
     * 
     * @ORM\OneToMany(targetEntity="Profile", mappedBy="setting")
     */
    private $profile;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set thema
     *
     * @param string $theme
     *
     * @return Setting
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }
    
    /**
     * Get profile
     *
     * @return profile
     */
    function getProfile()
    {
        return $this->profile;
    }
    
    /**
     * Set profile
     *
     * @param string $profile
     *
     * @return Setting
     */
    function setProfile(Profile $profile)
    {
        $this->profile = $profile;
        
        return $this;
    }
}
