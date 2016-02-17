<?php

namespace Epsoftware\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\MenuBundle\Entity\FirstMenu;
use Epsoftware\MenuBundle\Entity\ThirdMenu;
use Doctrine\Common\Collections\ArrayCollection;
use Epsoftware\UserBundle\Entity\Permission;

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
     * @ORM\Column(name="descricao", type="string", length=255)
     */
    private $descricao;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;
    
    /**
     * @var \Epsoftware\MenuBundle\Entity\FirstMenu
     *
     * @ORM\ManyToOne(targetEntity="FirstMenu", inversedBy="secondMenu", cascade={"persist"})
     * @ORM\JoinColumn(name="first_menu_id", referencedColumnName="id", onDelete="CASCADE", nullable=false) 
     */
    protected $firstMenu;
    
     /**
     * @var \Epsoftware\MenuBundle\Entity\ThirdMenu
     * 
     * @ORM\OneToMany(targetEntity="ThirdMenu", mappedBy="secondMenu") 
     */
    protected $thirdMenu;
    
    /**
     * @var \Doctrine\Common\Collections\Collection|SecondMenuGroup[]
     *
     * @ORM\ManyToMany(targetEntity="\Epsoftware\UserBundle\Entity\Permission", inversedBy="secondMenu")
     * @ORM\JoinTable(
     *  name="second_menu_permission",
     *  joinColumns={
     *      @ORM\JoinColumn(name="second_menu_id", referencedColumnName="id", onDelete="CASCADE")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="permission_id", referencedColumnName="id", onDelete="CASCADE")
     *  }
     * )
     */
    protected $permission;

    
    public function __construct()
    {
        $this->thirdMenu = new ArrayCollection();
        $this->permission = new ArrayCollection();
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
     * Get descricao
     * @return string descricao
     */
    function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set descricao
     * 
     * @param string $descricao
     * @return \Epsoftware\MenuBundle\Entity\SecondMenu
     */
    function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        
        return $this;
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
    
    /**
     * Get permission
     * @return \Doctrine\Common\Collections\Collection 
    */
    function getPermission()
    {
        return $this->permission;
    }
    
    /**
     * Set permission
     * @param \Epsoftware\UserBundle\Entity\Permission $permission
     * @return SecondMenu
     */
    function setPermission(Permission $permission)
    {
        $this->permission = $permission;
        
        return $this;
    }
    
    /**
     * @param ThirdMenu $thirdMenu
    */
    public function addThirdMenu(ThirdMenu $thirdMenu = null)
    {
        if($thirdMenu !== null){
            if (!$this->thirdMenu->contains($thirdMenu)) {
                $this->thirdMenu->add($thirdMenu);
            }
        }
        
    }
    
    /**
     * @param ThirdMenu $thirdMenu
    */
    public function removeThirdMenu(SecondMenu $thirdMenu)
    {
        if ($this->thirdMenu->contains($thirdMenu)) {
            $this->thirdMenu->removeElement($thirdMenu);
        }
    }
    
    /**
     * @param Permission $permission
    */
    public function addPermission(Permission $permission = null)
    {
        if($permission !== null){
            if (!$this->permission->contains($permission)) {
                $this->permission->add($permission);
                $permission->addSecondMenu($this);
            }
        }
    }
    
    /**
     * @param Permission $permission
    */
    public function removePermission(Permission $permission)
    {
        if ($this->permission->contains($permission)) {
            $this->permission->removeElement($permission);
            $permission->removeSecondMenu($this);
        }
    }

}

