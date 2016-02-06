<?php

namespace Epsoftware\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\AddressBundle\Entity\Address;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria")
 * @ORM\Entity(repositoryClass="Epsoftware\AddressBundle\Repository\CategoriaRepository")
 * 
 */
class Categoria
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
     * @ORM\Column(name="categoria", type="string", length=100)
     */
    private $categoria;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bgColor", type="string", length=100)
     */
    private $bgColor;
    
    /**
     *
     * @var \Epsoftware\AddressBundle\Entity\Address
     * 
     * @ORM\OneToMany(targetEntity="Address", mappedBy="categoria")
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
     * Set categoria
     *
     * @param string $categoria
     *
     * @return Categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    /**
     * Get bgColor
     * @return type
     */
    function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * Set bgColor
     * @param type $bgColor
     * @return \Epsoftware\AddressBundle\Entity\Categoria
     */
    function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
        
        return $this;
    }

        /**
     * 
     * Get address
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     * 
     * @param \Epsoftware\AddressBundle\Entity\Address $address
     * @return \Epsoftware\AddressBundle\Entity\Categoria
     */
    function setAddress(Address $address)
    {
        $this->address = $address;
        
        return $this;
    }

    
}

