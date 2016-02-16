<?php

namespace Epsoftware\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\MenuBundle\Entity\SecondMenu;
use Doctrine\Common\Collections\ArrayCollection;
use Epsoftware\UserBundle\Entity\Permission;

/**
 * FirstMenu
 *
 * @ORM\Table(name="first_menu")
 * @ORM\Entity(repositoryClass="Epsoftware\MenuBundle\Repository\FirstMenuRepository")
 */
class FirstMenu
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
     * @var \Epsoftware\MenuBundle\Entity\SecondMenu 
     * 
     * @ORM\OneToMany(targetEntity="SecondMenu", mappedBy="firstMenu") 
     */
    protected $secondMenu;
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection|FirstMenuGroup[]
     *
     * @ORM\ManyToMany(targetEntity="\Epsoftware\UserBundle\Entity\Permission", inversedBy="firstMenu")
     * @ORM\JoinTable(
     *  name="first_menu_permission",
     *  joinColumns={
     *      @ORM\JoinColumn(name="first_menu_id", referencedColumnName="id", onDelete="CASCADE")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="permission_id", referencedColumnName="id", onDelete="CASCADE")
     *  }
     * )
     */
    protected $permission;
    
    
    public function __construct()
    {
        $this->secondMenu = new ArrayCollection();
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
     * @return FirstMenu
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
     * @return \Epsoftware\MenuBundle\Entity\FirstMenu
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
     * @return FirstMenu
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
     * @return FirstMenu
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
     * 
     * @param \Epsoftware\MenuBundle\Entity\SecondMenu $secondMenu
     * @return FirstMenu
     */
    function setSecondMenu(SecondMenu $secondMenu)
    {
        $this->secondMenu = $secondMenu;
        
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
     * @param \Doctrine\Common\Collections\Collection $permission
     * @return FirstMenu
     */
    function setPermission(Collection $permission)
    {
        $this->permission = $permission;
        
        return $this;
    }

        
    /**
     * @param SecondMenu $secondMenu
    */
    public function addSecondMenu(SecondMenu $secondMenu = null)
    {
        if($secondMenu !== null){
            if (!$this->secondMenu->contains($secondMenu)) {
                $this->secondMenu->add($secondMenu);
            }
        }

    }
    
    /**
     * @param SecondMenu $secondMenu
    */
    public function removeSecondMenu(SecondMenu $secondMenu)
    {
        if ($this->secondMenu->contains($secondMenu)) {
            $this->secondMenu->removeElement($secondMenu);
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
                $permission->addFirstMenu($this);
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
            $permission->removeFirstMenu($this);
        }
    }


}

