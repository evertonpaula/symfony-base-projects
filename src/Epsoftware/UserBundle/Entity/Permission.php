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
}

