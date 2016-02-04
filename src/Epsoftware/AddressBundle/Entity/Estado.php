<?php

namespace Epsoftware\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\AddressBundle\Entity\Cidade;
use Epsoftware\AddressBundle\Entity\Address;

/**
 * Estado
 *
 * @ORM\Table(name="estado")
 * @ORM\Entity(repositoryClass="Epsoftware\AddressBundle\Repository\EstadoRepository")
 */
class Estado
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
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=10)
     */
    private $sigla;
    
    /**
     * @var \Epsoftware\AddressBundle\Entity\Cidade 
     * 
     * @ORM\OneToMany(targetEntity="Cidade", mappedBy="estado")
     */
    private $cidade;
    
     /**
     * @var \Epsoftware\AddressBundle\Entity\Address
     * 
     * @ORM\OneToMany(targetEntity="Address", mappedBy="estado")
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     *
     * @return Estado
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
     * Get cidade
     * 
     * @return \Epsoftware\AddressBundle\Entity\Cidade
     */
    function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set cidade
     * 
     * @param \Epsoftware\AddressBundle\Entity\Cidade $cidade
     * @return \Epsoftware\AddressBundle\Entity\Estado
     */
    function setCidade(Cidade $cidade)
    {
        $this->cidade = $cidade;
        
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
     * @return \Epsoftware\AddressBundle\Entity\Estado
     */
    function setAddress(Address $address)
    {
        $this->address = $address;
        
        return $this;
    }


}
