<?php

namespace Epsoftware\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Epsoftware\UserBundle\Entity\User;

/**
 * Logger
 *
 * @ORM\Table(name="logger")
 * @ORM\Entity(repositoryClass="Epsoftware\UserBundle\Repository\LoggerRepository")
 */
class Logger
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
     * @ORM\Column(name="local", type="string", length=255)
     */
    private $local;

    /**
     * @var string
     *
     * @ORM\Column(name="acao", type="string", length=255)
     */
    private $acao;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    private $observacao;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
    */
    private $created;
    
    /**
     * @var \Epsoftware\PerfilBundle\Entity\User
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="logger")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
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
     * Set local
     *
     * @param string $local
     *
     * @return Logger
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return string
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set acao
     *
     * @param string $acao
     *
     * @return Logger
     */
    public function setAcao($acao)
    {
        $this->acao = $acao;

        return $this;
    }

    /**
     * Get acao
     *
     * @return string
     */
    public function getAcao()
    {
        return $this->acao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     *
     * @return Logger
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }
    
    /**
     * Get created
     * 
     * @return \Datetime
     */
    function getCreated()
    {
        return $this->created;
    }

    /**
     * Get user
     * 
     * @return User
     */
    function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set created
     * @param \DateTime $created
     * @return \Epsoftware\UserBundle\Entity\Logger
     */
    function setCreated(\DateTime $created)
    {
        $this->created = $created;
        
        return $this;
    }
    
    /**
     * Set user
     * @param \Epsoftware\PerfilBundle\Entity\User $user
     * @return \Epsoftware\UserBundle\Entity\Logger
     */
    function setUser(User $user = null)
    {
        $this->user = $user;
        
        return $this;
    }

}

