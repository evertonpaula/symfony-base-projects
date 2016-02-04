<?php

namespace Epsoftware\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Epsoftware\AddressBundle\Entity\Cidade;
use Epsoftware\AddressBundle\Entity\Estado;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Epsoftware\AddressBundle\Repository\AddressRepository")
 */
class Address
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
     * @Assert\NotBlank(message="É obrigatório informar valor para CEP", groups={"address"})
     * @Assert\Regex(pattern="/^[0-9]{5}\-[0-9]{3}$/",message="Número do cpf inválido", groups={"address"})
     * @ORM\Column(name="cep", type="string", length=20)
     */
    private $cep;
    
    /**
     * @var string
     * @Assert\NotBlank(message="É obrigatório informar valor para logradouro(ex.: Rua ..., Av. ...)", groups={"address"})
     * @ORM\Column(name="logradouro", type="string", length=255)
     */
    private $logradouro;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=10, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="complemento", type="string", length=255, nullable=true)
     */
    private $complemento;

    /**
     * @var string
     *
     * @ORM\Column(name="bairro", type="string", length=255, nullable=true)
     */
    private $bairro;

    /**
     * @var \Epsoftware\AddressBundle\Entity\Cidade
     *
     * @ORM\ManyToOne(targetEntity="Cidade", inversedBy="address")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cidade;
    
    /**
     * @var \Epsoftware\AddressBundle\Entity\Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="address")
     * @ORM\JoinColumn(nullable=false)
     */
    private $estado;
        
    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;
    
    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;
    
    /**
     * @var string
     *
     * @ORM\Column(name="googleFormat", type="string", length=255, nullable=true)
     */
    private $googleFormat;
        
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
     * Get cep
     * @return string
     */
    function getCep()
    {
        return $this->cep;
    }

    /**
     * Set cep
     * @param type $cep
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function setCep($cep)
    {
        $this->cep = $cep;
        
        return $this;
    }

        
    /**
     * Set logradouro
     *
     * @param string $logradouro
     *
     * @return Address
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    /**
     * Get logradouro
     *
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Address
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     *
     * @return Address
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     *
     * @return Address
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
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
     * Get estado
     * 
     * @return \Epsoftware\AddressBundle\Entity\Estado
     */
    function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cidade
     * 
     * @param \Epsoftware\AddressBundle\Entity\Cidade $cidade
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function setCidade(Cidade $cidade)
    {
        $this->cidade = $cidade;
        
        return $this;
    }

    /**
     * Set estado
     * 
     * @param \Epsoftware\AddressBundle\Entity\Estado $estado
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function setEstado(\Epsoftware\AddressBundle\Entity\Estado $estado)
    {
        $this->estado = $estado;
        
        return $this;
    }
    
    /**
     * Get longitude
     *
     * @return string
     */
    function getLongitude()
    {
        return $this->longitude;
    }
    
    /**
     * Get latitude
     *
     * @return string
     */
    function getLatitude()
    {
        return $this->latitude;
    }
    
    /**
     * Get googleFormat
     *
     * @return string
     */
    function getGoogleFormat()
    {
        return $this->googleFormat;
    }
    
    /**
     * Set longitude
     * @param type $longitude
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        
        return $this;
    }
    
    /**
     * Set latidude
     * @param type $latitude
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        
        return $this;
    }
    
    /**
     * Set googleFormat
     * @param type $googleFormat
     * @return \Epsoftware\AddressBundle\Entity\Address
     */
    function setGoogleFormat($googleFormat)
    {
        $this->googleFormat = $googleFormat;
        
        return $this;
    }


}

