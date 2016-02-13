<?php

namespace Epsoftware\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\MenuBundle\Entity\FirstMenu;
use Epsoftware\MenuBundle\Entity\ThirdMenu;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SecondMenu
 *
 * @ORM\Table(name="second_menu")
 * @ORM\Entity(repositoryClass="Epsoftware\MenuBundle\Repository\SecondMenuRepository")
 */
class SecondMenu
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
     * @var \Epsoftware\MenuBundle\Entity\FirstMenu
     *
     * @ORM\ManyToOne(targetEntity="FirstMenu", inversedBy="secondMenu")
     * @ORM\JoinColumn(name="first_menu_id", referencedColumnName="id", onDelete="CASCADE") 
     */
    protected $firstMenu;
    
     /**
     * @var \Epsoftware\MenuBundle\Entity\ThirdMenu
     * 
     * @ORM\OneToMany(targetEntity="ThirdMenu", mappedBy="secondMenu", cascade={"remove"}) 
     */
    protected $thirdMenu;

    
    public function __construct()
    {
        $this->thirdMenu = ArrayCollection();
    }
    
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
     * @return SecondMenu
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
     * @return SecondMenu
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
     * @return SecondMenu
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
     * Get firstMenu
     * @return \Epsoftware\MenuBundle\Entity\FirstMenu
     */
    function getFirstMenu()
    {
        return $this->firstMenu;
    }

    /**
     * Get thirdMenu
     * @return \Epsoftware\MenuBundle\Entity\ThirdMenu
     */
    function getThirdMenu()
    {
        return $this->thirdMenu;
    }
    
    /**
     * Set firstMenu
     * @param \Epsoftware\MenuBundle\Entity\FirstMenu $firstMenu
     * @return \Epsoftware\MenuBundle\Entity\SecondMenu
     */
    function setFirstMenu(FirstMenu $firstMenu)
    {
        $this->firstMenu = $firstMenu;
        
        return $this;
    }
    
    /**
     * Set thirdMenu
     * @param \Epsoftware\MenuBundle\Entity\ThirdMenu $thirdMenu
     * @return \Epsoftware\MenuBundle\Entity\SecondMenu
     */
    function setThirdMenu(ThirdMenu $thirdMenu)
    {
        $this->thirdMenu = $thirdMenu;
        
        return $this;
    }
}

