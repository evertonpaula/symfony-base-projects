<?php

namespace Epsoftware\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\AddressBundle\Entity\Estado;
use Epsoftware\AddressBundle\Entity\Address;

/**
 * Cidade
 *
 * @ORM\Table(name="cidade")
 * @ORM\Entity(repositoryClass="Epsoftware\AddressBundle\Repository\CidadeRepository")
 * 
 */
class Cidade
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
     * @ORM\Column(name="cidade", type="string", length=255)
     */
    private $cidade;

    /**
     * @var \Epsoftware\AddressBundle\Entity\Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="cidade")
     * @ORM\JoinColumn(nullable=false)
     */
    private $estado;

    /**
     * @var \Epsoftware\AddressBundle\Entity\Address
     * 
     * @ORM\OneToMany(targetEntity="Address", mappedBy="cidade")
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
     * Set cidade
     *
     * @param string $cidade
     *
     * @return Cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get cidade
     *
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set estado
     *
     * @param \Epsoftware\AddressBundle\Entity\Estado $estado
     *
     * @return Cidade
     */
    public function setEstado(Estado $estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Epsoftware\AddressBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
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
     * @return \Epsoftware\AddressBundle\Entity\Estado
     */
    function setAddress(Address $address)
    {
        $this->address = $address;
        
        return $this;
    }
}

