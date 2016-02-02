<?php

namespace Epsoftware\PerfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\PerfilBundle\Entity\Setting;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="Epsoftware\PerfilBundle\Repository\ThemeRepository")
 */
class Theme
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
     * @ORM\Column(name="skin", type="string", length=50)
     */
    private $skin;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="legend", type="string", length=100)
     */
    private $legend;

    /**
     * @var \Epsoftware\PerfilBundle\Entity\Setting
     * 
     * @ORM\OneToMany(targetEntity="Setting", mappedBy="theme")
     */
    protected  $setting;

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
     * Set skin
     *
     * @param string $skin
     *
     * @return Theme
     */
    public function setSkin($skin)
    {
        $this->skin = $skin;

        return $this;
    }

    /**
     * Get skin
     *
     * @return string
     */
    public function getSkin()
    {
        return $this->skin;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Theme
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set legend
     *
     * @param string $legend
     *
     * @return Theme
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * Get legend
     *
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

}

