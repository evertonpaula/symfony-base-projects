<?php

namespace Epsoftware\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forms
 *
 * @ORM\Table(name="forms")
 * @ORM\Entity(repositoryClass="Epsoftware\MenuBundle\Repository\FormsRepository")
 */
class Forms
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255)
     */
    private $action;
    
    /**
     * @var \Doctrine\Common\Collections\Collection|FormsGroup[]
     *
     * @ORM\ManyToMany(targetEntity="\Epsoftware\UserBundle\Entity\Permission", inversedBy="forms")
     * @ORM\JoinTable(
     *  name="forms_permission",
     *  joinColumns={
     *      @ORM\JoinColumn(name="forms_id", referencedColumnName="id", onDelete="CASCADE")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="permission_id", referencedColumnName="id", onDelete="CASCADE")
     *  }
     * )
    */
    protected $permission;

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
     * Set name
     *
     * @param string $name
     *
     * @return Forms
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Forms
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
     * Set description
     *
     * @param string $description
     *
     * @return Forms
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Forms
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @param Permission $permission
    */
    public function addPermission(Permission $permission)
    {
        if (!$this->permission->contains($permission)) {
            $this->permission->add($permission);
            $permission->addMenu($this);
        }
    }
    
    /**
     * @param Permission $permission
    */
    public function removePermission(Permission $permission)
    {
        if ($this->permission->contains($permission)) {
            $this->permission->removeElement($permission);
            $permission->removeMenu($this);
        }
    }
}

