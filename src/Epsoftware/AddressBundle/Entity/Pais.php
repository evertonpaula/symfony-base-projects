<?php

namespace Epsoftware\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\AddressBundle\Entity\Estado;
use Epsoftware\AddressBundle\Entity\Address;

/**
 * Estado
 *
 * @ORM\Table(name="pais")
 * @ORM\Entity(repositoryClass="Epsoftware\AddressBundle\Repository\PaisRepository")
 */
class Pais
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
     * @ORM\Column(name="pais", type="string", length=255)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=10)
     */
    private $sigla;
    
    /**
     * @var \Epsoftware\AddressBundle\Entity\Estado 
     * 
     * @ORM\OneToMany(targetEntity="Estado", mappedBy="pais")
     */
    private $estado;
    
     /**
     * @var \Epsoftware\AddressBundle\Entity\Address
     * 
     * @ORM\OneToMany(targetEntity="Address", mappedBy="pais")
     */
    private $address;
    
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
     * Set pais
     *
     * @param string $pais
     *
     * @return Pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     *
     * @return Pais
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }
    
    /**
     * Get estado
     * 
     * @return \Epsoftware\AddressBundle\Entity\Estado
     */
    function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set estado
     * 
     * @param \Epsoftware\AddressBundle\Entity\Estado $estado
     * @return \Epsoftware\AddressBundle\Entity\Estado
     */
    function setEstado(Estado $estado)
    {
        $this->estado = $estado;
        
        return $this;
    }
    
    /**
     * Get address
     * 
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Set address
     * 
     * @param \Epsoftware\AddressBundle\Entity\Address  $address
     * @return \Epsoftware\AddressBundle\Entity\Pais
     */
    function setAddress(Address $address)
    {
        $this->address = $address;
        
        return $this;
    }


}
