<?php

namespace Epsoftware\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Permission
 *
 * @ORM\Table(name="permission")
 * @ORM\Entity(repositoryClass="Epsoftware\UserBundle\Repository\PermissionRepository")
 */
class Permission
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
     * @ORM\Column(name="roles", type="string", length=25 , nullable=false)
    */
    private $role;
    
    /**
     * @var \Doctrine\Common\Collections\Collection|User
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="permission")
    */
    private $user;
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection|FirstMenu
     *
     * @ORM\ManyToMany(targetEntity="\Epsoftware\MenuBundle\Entity\FirstMenu", mappedBy="permission")
    */
    private $firstMenu;
    
    /**
     * @var \Doctrine\Common\Collections\Collection|SecondMenu
     *
     * @ORM\ManyToMany(targetEntity="\Epsoftware\MenuBundle\Entity\SecondMenu", mappedBy="permission")
    */
    private $secondMenu;
    
    /**
     * @var \Doctrine\Common\Collections\Collection|ThirdMenu
     *
     * @ORM\ManyToMany(targetEntity="\Epsoftware\MenuBundle\Entity\ThirdMenu", mappedBy="permission")
    */
    private $thirdMenu;
    
    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->user = new ArrayCollection();
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
     * Set role
     *
     * @param string $role
     *
     * @return Permission
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->addPermission($this);
        }
    }
    
    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            $user->removePermission($this);
        }
    }
    
    /**
     * @param FirstMenu $firstMenu
     */
    public function addFirstMenu(\Epsoftware\MenuBundle\Entity\FirstMenu $firstMenu)
    {
        if (!$this->firstMenu->contains($firstMenu)) {
            $this->firstMenu->add($firstMenu);
            $firstMenu->addPermission($this);
        }
    }
    
    /**
     * @param FirstMenu $firstMenu
     */
    public function removeFirstMenu(\Epsoftware\MenuBundle\Entity\FirstMenu $firstMenu)
    {
        if ($this->firstMenu->contains($firstMenu)) {
            $this->firstMenu->removeElement($firstMenu);
            $firstMenu->removePermission($this);
        }
    }
    
    /**
     * @param SecondMenu $secondMenu
     */
    public function addSecondMenu(\Epsoftware\MenuBundle\Entity\SecondMenu $secondMenu)
    {
        if (!$this->secondMenu->contains($secondMenu)) {
            $this->secondMenu->add($secondMenu);
            $secondMenu->addPermission($this);
        }
    }
    
    /**
     * @param SecondMenu $secondMenu
     */
    public function removeSecondMenu(\Epsoftware\MenuBundle\Entity\SecondMenu $secondMenu)
    {
        if ($this->secondMenu->contains($secondMenu)) {
            $this->secondMenu->removeElement($secondMenu);
            $secondMenu->removePermission($this);
        }
    }
    
    /**
     * @param ThirdMenu $thirdMenu
     */
    public function addThirdMenu(\Epsoftware\MenuBundle\Entity\ThirdMenu $thirdMenu)
    {
        if (!$this->thirdMenu->contains($thirdMenu)) {
            $this->thirdMenu->add($thirdMenu);
            $thirdMenu->addPermission($this);
        }
    }
    
    /**
     * @param ThirdMenu $thirdMenu
     */
    public function removeThirdMenu(\Epsoftware\MenuBundle\Entity\ThirdMenu $thirdMenu)
    {
        if ($this->thirdMenu->contains($thirdMenu)) {
            $this->thirdMenu->removeElement($thirdMenu);
            $thirdMenu->removePermission($this);
        }
    }
    
    function getFirstMenu()
    {
        return $this->firstMenu;
    }

    function getSecondMenu()
    {
        return $this->secondMenu;
    }

    function getThirdMenu()
    {
        return $this->thirdMenu;
    }

    function getForms()
    {
        return $this->forms;
    }

    function setFirstMenu(\Doctrine\Common\Collections\Collection $firstMenu)
    {
        $this->firstMenu = $firstMenu;
    }

    function setSecondMenu(\Doctrine\Common\Collections\Collection $secondMenu)
    {
        $this->secondMenu = $secondMenu;
    }
}
