<?php

namespace Epsoftware\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\MenuBundle\Entity\SecondMenu;

/**
 * ThirdMenu
 *
 * @ORM\Table(name="third_menu")
 * @ORM\Entity(repositoryClass="Epsoftware\MenuBundle\Repository\ThirdMenuRepository")
 */
class ThirdMenu
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
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;
    
    
    /**
     * @var \Epsoftware\MenuBundle\Entity\SecondMenu
     * 
     * @ORM\ManyToOne(targetEntity="SecondMenu", inversedBy="thirdMenu")
     * @ORM\JoinColumn(name="second_menu_id", referencedColumnName="id", onDelete="CASCADE") 
     */
    protected $secondMenu;


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
     * Set title
     *
     * @param string $title
     *
     * @return ThirdMenu
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return ThirdMenu
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
     * Set path
     *
     * @param string $path
     *
     * @return ThirdMenu
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Get secondMenu
     * @return \Epsoftware\MenuBundle\Entity\SecondMenu
     */
    function getSecondMenu()
    {
        return $this->secondMenu;
    }
    
    /**
     * Set secondMenu
     * @param \Epsoftware\MenuBundle\Entity\SecondMenu $secondMenu
     * @return \Epsoftware\MenuBundle\Entity\ThirdMenu
     */
    function setSecondMenu(SecondMenu $secondMenu) 
    {
        $this->secondMenu = $secondMenu;
        
        return $this;
    }


}

