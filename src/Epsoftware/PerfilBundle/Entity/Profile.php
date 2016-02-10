<?php

namespace Epsoftware\PerfilBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Epsoftware\PerfilBundle\Entity\Setting;
use Epsoftware\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Epsoftware\PerfilBundle\Entity\Profissao;
use Epsoftware\AddressBundle\Entity\Address;
use Epsoftware\PerfilBundle\Entity\Genero;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Profile
 *
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="Epsoftware\PerfilBundle\Repository\ProfileRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="cpf", message="Desculpe mas este cpf já foi cadastrado anteriormente.", groups={"profile"})
 */
class Profile
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
     * @ORM\Column(name="nome", type="string", length=50,  nullable=false)
     * @Assert\NotBlank(message="É obrigatório preenchimento do nome", groups={"profile"})
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sobrenome", type="string", length=80,  nullable=false)
     * @Assert\NotBlank(message="É obrigatório preenchimento do sobrenome", groups={"profile"})
     */
    private $sobrenome;

    /**
     * @var \DateTime
     * 
     * @Assert\Date(message="A data de nascimento preenchida não é inválida", groups={"profile"})
     * @Assert\NotBlank(message="É obrigatório preenchimento da data de nascimento", groups={"profile"})
     * @ORM\Column(name="dtNascimento", type="date",  nullable=false)
     */
    private $dtNascimento;

    /**
     * @var string
     *
     * @Assert\Regex(pattern="/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/",message="Número do cpf inválido", groups={"profile"})
     * @Assert\NotBlank(message="É obrigatório preenchimento do cpf", groups={"profile"})
     * @ORM\Column(name="cpf", type="string", nullable=false)
     */
    private $cpf;

    /**
     * @var string
     *
     * @Assert\Regex(pattern="/^\([1-9]{2}\) [2-9][0-9]{3,4}\-[0-9]{4}$/",message="Número de telefone inválido", groups={"profile"})
     * @ORM\Column(name="telefone", type="string", nullable=true)
     */
    private $telefone;
    
    /**
     * @var string
     *
     * @Assert\Regex(pattern="/^\([1-9]{2}\) [2-9][0-9]{3,4}\-[0-9]{4}$/",message="Número de celular inválido", groups={"profile"})
     * @ORM\Column(name="celular", type="string", nullable=true)
     */
    private $celular;
    
    
    /**
     * @var \Epsoftware\PerfilBundle\Entity\Genero
     * 
     * @Assert\NotBlank(message="É obrigatório preenchimento do campo gênero", groups={"registration", "profile"})
     * @ORM\ManyToOne(targetEntity="Genero", inversedBy="profile")
     * @ORM\JoinColumn(nullable=false, onDelete="SET NULL")
     */
    private $genero;
    
     /**
     * @var \Epsoftware\PerfilBundle\Entity\Profissao
     * 
     * @Assert\NotBlank(message="É obrigatório a escolha de uma profissão", groups={"profile"})
     * @ORM\ManyToOne(targetEntity="Profissao", inversedBy="profile")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $profissao;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=true)
     */
    private $descricao;
       
    /**
     * @var \Epsoftware\PerfilBundle\Entity\Setting
     * 
     * @ORM\ManyToOne(targetEntity="Setting", inversedBy="profile")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $setting;
    
    /**
     * @var \Epsoftware\UserBundle\Entity\User
     * @ORM\OneToOne(targetEntity="\Epsoftware\UserBundle\Entity\User", mappedBy="profile")
     */
    protected $user;
    
    /**
     *
     * @var \Epsoftware\AddressBundle\Entity\Address
     * 
     * @ORM\ManyToMany(targetEntity="\Epsoftware\AddressBundle\Entity\Address", cascade={"remove"})
     * @ORM\JoinTable(name="profile_address",
     *      joinColumns={@ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="address_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $address;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
    */
    private $updated;

    public function __construct()   
    {
        $this->address = new ArrayCollection();
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
     * Set nome
     *
     * @param string $nome
     *
     * @return Profile
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set sobrenome
     *
     * @param string $sobrenome
     *
     * @return Profile
     */
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;

        return $this;
    }

    /**
     * Get sobrenome
     *
     * @return string
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * Set dtNascimento
     *
     * @param \DateTime $dtNascimento
     *
     * @return Profile
     */
    public function setDtNascimento($dtNascimento)
    {
        $this->dtNascimento = $dtNascimento;

        return $this;
    }

    /**
     * Get dtNascimento
     *
     * @return \DateTime
     */
    public function getDtNascimento()
    {
        return $this->dtNascimento;
    }

    /**
     * Set cpf
     *
     * @param string $cpf
     *
     * @return Profile
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get cpf
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }
    
    /**
     * Get telefone
     *
     * @return string
     */
    function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Get celular
     *
     * @return string
     */
    function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     *
     * @return Profile
     */
    function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        
        return $this;
    }
    
    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return Profile
     */
    function setCelular($celular)
    {
        $this->celular = $celular;
        
        return $this;
    }
        
    /**
     * Get genero
     *
     * @return \Epsoftware\PerfilBundle\Entity\Genero
     */
    function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set genero
     *
     * @param \Epsoftware\PerfilBundle\Entity\Genero $genero
     *
     * @return Profile
     */
    function setGenero(Genero $genero = null)
    {
        $this->genero = $genero;
        
        return $this;
    }
    
    /**
     * Get profissao
     *
     * @return \Epsoftware\PerfilBundle\Entity\Profissao
     */
    function getProfissao()
    {
        return $this->profissao;
    }

    /**
     * Set profissao
     *
     * @param \Epsoftware\PerfilBundle\Entity\Profissao  $profissao
     *
     * @return Profile
     */
    function setProfissao(Profissao $profissao = null)
    {
        $this->profissao = $profissao;
        
        return $this;
    }
        
    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Profile
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }
    
    /**
     * Get setting
     *
     * @return \Epsoftware\PerfilBundle\Entity\Setting
     */
    function getSetting()
    {
        return $this->setting;
    }
    
    /**
     * Set setting
     *
     * @param \Epsoftware\PerfilBundle\Entity\Setting $setting
     *
     * @return Profile
     */
    function setSetting(Setting $setting)
    {
        $this->setting = $setting;
        
        return $this;
    }
    
     /**
     * Get user
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
     * @param \Epsoftware\UserBundle\Entity\User $user
     *
     * @return Profile
     */
    function setUser(User $user)
    {
        $this->user = $user;
        
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
     * @param \Epsoftware\AddressBundle\Entity\Address $address
     * @return \Epsoftware\PerfilBundle\Entity\Profile
     */
    function setAddress(Address $address) {
        $this->address = $address;
        
        return $this;
    }
    
    /**
     * Add Address
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        if (!$this->address->contains($address))
        {
            $this->address->add($address);
        }
    }
    
    /**
     * Remove Address
     * 
     * @param Address $address
     */
    public function removeAddress(Address $address)
    {
        if ($this->address->contains($address)) {
            $this->address->removeElement($address);
        }
    }
        
    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
