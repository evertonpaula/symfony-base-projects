<?php

namespace Epsoftware\PerfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epsoftware\PerfilBundle\Entity\Setting;
use Epsoftware\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Epsoftware\PerfilBundle\Entity\Profissao;

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
     * @Assert\NotBlank(message="É obrigatório preenchimento do nome", groups={"registration", "profile"})
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sobrenome", type="string", length=80,  nullable=false)
     * @Assert\NotBlank(message="É obrigatório preenchimento do sobrenome", groups={"registration", "profile"})
     */
    private $sobrenome;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="É obrigatório preenchimento da data de nascimento", groups={"registration", "profile"})
     * @ORM\Column(name="dtNascimento", type="date",  nullable=false)
     */
    private $dtNascimento;

    /**
     * @var int
     *
     * @ORM\Column(name="cpf", type="bigint", nullable=false)
     * @Assert\NotBlank(message="É obrigatório preenchimento do cpf", groups={"registration", "profile"})
     */
    private $cpf;

    /**
     * @var int
     *
     * @ORM\Column(name="telefone", type="integer", nullable=true)
     */
    private $telefone;
    
    /**
     * @var int
     *
     * @ORM\Column(name="celular", type="integer", nullable=true)
     */
    private $celular;
    
    /**
     * @var int
     * @Assert\NotBlank(message="É obrigatório preenchimento do campo gênero", groups={"registration", "profile"})
     * @ORM\Column(name="genero", type="integer", nullable=false)
     */
    private $genero;
    
     /**
     * @var \Epsoftware\PerfilBundle\Entity\Profissao
     * 
     * @ORM\ManyToOne(targetEntity="Profissao", inversedBy="profile")
     * @ORM\JoinColumn(nullable=true)
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
     * @ORM\JoinColumn(nullable=true)
     */
    protected $setting;
    
    /**
     * @var \Epsoftware\UserBundle\Entity\User
     * @ORM\OneToOne(targetEntity="\Epsoftware\UserBundle\Entity\User", mappedBy="profile")
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
     * @param integer $cpf
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
     * @return int
     */
    public function getCpf()
    {
        return $this->cpf;
    }
    
    /**
     * Get telefone
     *
     * @return int
     */
    function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Get celular
     *
     * @return int
     */
    function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set telefone
     *
     * @param integer $telefone
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
     * @param integer $celular
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
     * @return int
     */
    function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set genero
     *
     * @param int $genero
     *
     * @return Profile
     */
    function setGenero($genero)
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
    function setProfissao(Profissao $profissao)
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
    
   
}
