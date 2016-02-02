<?php

namespace Epsoftware\PerfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\PerfilBundle\Entity\Profile;

/**
 * Profissao
 *
 * @ORM\Table(name="profissao")
 * @ORM\Entity(repositoryClass="Epsoftware\PerfilBundle\Repository\ProfissaoRepository")
 */
class Profissao
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
     * @ORM\Column(name="profissao", type="string", length=150)
     */
    private $profissao;
    
    /**
     * @var \Epsoftware\PerfilBundle\Entity\Profile
     * 
     * @ORM\OneToMany(targetEntity="Profile", mappedBy="profissao")
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
     * Set profissao
     *
     * @param string $profissao
     *
     * @return Profissao
     */
    public function setProfissao($profissao)
    {
        $this->profissao = $profissao;

        return $this;
    }

    /**
     * Get profissao
     *
     * @return string
     */
    public function getProfissao()
    {
        return $this->profissao;
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
     *
     * @return Profissao
     */
    function setProfile(Profile $profile)
    {
        $this->profile = $profile;
        
        return $this;
    }


}

