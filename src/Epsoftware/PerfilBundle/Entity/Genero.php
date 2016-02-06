<?php

namespace Epsoftware\PerfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\PerfilBundle\Entity\Profile;

/**
 * Genero
 *
 * @ORM\Table(name="genero")
 * @ORM\Entity(repositoryClass="Epsoftware\PerfilBundle\Repository\GeneroRepository")
 */
class Genero
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
     * @ORM\Column(name="genero", type="string", length=100)
     */
    private $genero;
    
     /**
     * @var \Epsoftware\PerfilBundle\Entity\Profile
     * 
     * @ORM\OneToMany(targetEntity="Profile", mappedBy="genero")
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
     * Set genero
     *
     * @param string $genero
     *
     * @return Genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }
    
    /**
     * Get profile
     * 
     * @return \Epsoftware\PerfilBundle\Entity\Profile
     */
    function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set profile
     * 
     * @param \Epsoftware\PerfilBundle\Entity\Profile $profile
     * @return \Epsoftware\PerfilBundle\Entity\Genero
     */
    function setProfile(Profile $profile) {
        $this->profile = $profile;
        
        return $this;
    }
}

