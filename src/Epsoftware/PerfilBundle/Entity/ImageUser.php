<?php

namespace Epsoftware\PerfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\UserBundle\Entity\User;

/**
 * ImageUser
 *
 * @ORM\Table(name="image_user")
 * @ORM\Entity(repositoryClass="Epsoftware\PerfilBundle\Repository\ImageUserRepository")
 */
class ImageUser extends UploadImage
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
     * @var \Epsoftware\UserBundle\Entity\User
     * @ORM\OneToOne(targetEntity="\Epsoftware\UserBundle\Entity\User", mappedBy="image")
     */
    protected $user;
    
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
     * Get id
     *
     * @return \Epsoftware\UserBundle\Entity\User
     */
    function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set user
     * 
     * @param User $user
     * @return \Epsoftware\PerfilBundle\Entity\ImageUser
     */
    function setUser(User $user)
    {
        $this->user = $user;
        
        return $this;
    }

    /**
     * getUploadDir
     * 
     * @return string
     */
    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'images/users';
    }


}

