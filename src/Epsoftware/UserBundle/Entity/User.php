<?php

namespace Epsoftware\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Serializable;
use Epsoftware\PerfilBundle\Entity\Profile;
use Epsoftware\PerfilBundle\Entity\ImageUser;

/**
 * User
 *
 * @ORM\Table(name="users_login")
 * @ORM\Entity(repositoryClass="Epsoftware\UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Desculpe mas este e-mail já foi cadastrado anteriormente, tente outro e-mail.", groups={"registration"})
 * @UniqueEntity(fields="username", message="Desculpe mas este usuário já foi cadastrado anteriormente, tente outro usuário.", groups={"registration"})
 */
class User implements AdvancedUserInterface, Serializable, EncoderAwareInterface
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
     * @Assert\NotBlank(message="O usuário não pode estar em branco", groups={"registration", "login"})
     * @Assert\Regex(pattern="/^([a-zA-Z0-9]+){3,15}$/", message="O login do usuário deve conter entre 3 e 15 caracteres alfanuméricos  , sem nenhum caracter diferenciado. ", groups={"registration"})
     * @ORM\Column(name="username", type="string", length=15, unique=true)
     */
    protected $username;
    
    /**
     * @var string
     * 
     * @Assert\NotBlank(message = "É obrigatório o uso de um e-mail válido.", groups={"registration"})
     * @Assert\Email(
     *     message = "O e-mail '{{ value }}' não é um tipo válido.",
     *     checkMX = true,
     *     groups={"registration"}
     * )
     * @ORM\Column(name="email", type="string", length=255)
     */
    protected $email;
    
    /**
     * @var string
     
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * 
     * @var string
     * @Assert\NotBlank(message = "Use uma senha válida.", groups={"registration", "login"})
     * @Assert\Regex(pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,20}/",message = "Sua senha deve conter entre 6 e 20 caracteres alfanuméricos diferenciando letras maiúsculas de minúscalas.", groups={"registration"})
     */
    protected $plainPassword;
    
    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

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

    
    /**
     * @var boolean $agree
     * 
     * @Assert\IsTrue(message="Você deve concordar com os termos de uso.", groups={"registration"})
     * @ORM\Column(name="agree", type="boolean")
     */
    protected $agree;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="isEnable", type="boolean")
     */
    private $isEnable = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="isAccountNonExpired", type="boolean")
     */
    private $isAccountNonExpired = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="isAccountNonLocked", type="boolean")
     */
    private $isAccountNonLocked = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="isCredentialNonExpired", type="boolean")
     */
    private $isCredentialNonExpired = false;

    /**
     * @var \Doctrine\Common\Collections\Collection|UserGroup[]
     *
     * @ORM\ManyToMany(targetEntity="Permission", inversedBy="user", cascade={"remove"})
     * @ORM\JoinTable(
     *  name="user_permission",
     *  joinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $permission;
    
    /**
     * 
     * @var string
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;
    
    /**
     * @var array $roles
     * 
     */
    private $roles = array();
    
   /**
    * @var recaptcha
    * @Recaptcha\IsTrue(message="Você deve preencher o campo 'Não sou um robô'", groups={"registration", "login"})
    */
    protected $recaptcha;
    
    /**
     * @var \Epsoftware\PerfilBundle\Entity\Profile
     * 
     * @ORM\OneToOne(targetEntity="\Epsoftware\PerfilBundle\Entity\Profile", inversedBy="user")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", nullable=true)
     */
    protected $profile;
    
    /**
     * @var \Epsoftware\PerfilBundle\Entity\ImageUser
     * 
     * @ORM\OneToOne(targetEntity="\Epsoftware\PerfilBundle\Entity\ImageUser", inversedBy="user")
     * @ORM\JoinColumn(name="image_user_id", referencedColumnName="id", nullable=true)
    */
    protected $image;
    
    
    public function __construct() 
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->permission = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    
    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     *
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
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

    /**
     * Get agree
     * @return boolean
     */
    function getAgree()
    {
        return $this->agree;
    }

    /**
     * Set agree
     * @param boolean $agree
     */
    function setAgree($agree)
    {
        $this->agree = $agree;
    }

        
    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     *
     * @return User
     */
    public function setIsEnable($isEnable)
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    /**
     * Get isEnable
     *
     * @return bool
     */
    public function getIsEnable()
    {
        return $this->isEnable;
    }

    /**
     * Set isAccountNonExpired
     *
     * @param boolean $isAccountNonExpired
     *
     * @return User
     */
    public function setIsAccountNonExpired($isAccountNonExpired)
    {
        $this->isAccountNonExpired = $isAccountNonExpired;

        return $this;
    }

    /**
     * Get isAccountNonExpired
     *
     * @return bool
     */
    public function getIsAccountNonExpired()
    {
        return $this->isAccountNonExpired;
    }

    /**
     * Set isAccountNonLocked
     *
     * @param boolean $isAccountNonLocked
     *
     * @return User
     */
    public function setIsAccountNonLocked($isAccountNonLocked)
    {
        $this->isAccountNonLocked = $isAccountNonLocked;

        return $this;
    }

    /**
     * Get isAccountNonLocked
     *
     * @return bool
     */
    public function getIsAccountNonLocked()
    {
        return $this->isAccountNonLocked;
    }

    /**
     * Set isCredentialNonExpired
     *
     * @param boolean $isCredentialNonExpired
     *
     * @return User
     */
    public function setIsCredentialNonExpired($isCredentialNonExpired)
    {
        $this->isCredentialNonExpired = $isCredentialNonExpired;

        return $this;
    }

    /**
     * Get isCredentialNonExpired
     *
     * @return bool
     */
    public function getIsCredentialNonExpired()
    {
        return $this->isCredentialNonExpired;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        foreach ($this->permission as $permission):
            array_push($this->roles, $permission->getRole());
        endforeach;
        return $this->roles;
    }
    
    /**
     * Set Roles
     * 
     */
    private function setRoles(Permission $permission)
    {
        array_push($this->roles, $permission->getRole());
    }
    
    /**
     * @param Permission $permission
     */
    public function addPermission(Permission $permission)
    {
        if (!$this->permission->contains($permission)) {
            $this->permission->add($permission);
            $permission->addUser($this);
            $this->setRoles($permission);
        }
    }
    
    /**
     * @param Permission $permission
     */
    public function removePermission(Permission $permission)
    {
        if ($this->permission->contains($permission)) {
            unset($this->roles[array_search($permission->getRole(), $this->roles)]);
            $this->permission->removeElement($permission);
            $permission->removeUser($this);
        }
    }
    
    /**
     * Get uri
     * @return string
     */
    function getUri()
    {
        return $this->uri;
    }
    
    /**
     * Set uri
     * @param string $uri
     */
    function setUri($uri) {
        $this->uri = $uri;
    }
    
    /**
     * Get recaptcha
     * @return string
     */
    function getRecaptcha()
    {
        return $this->recaptcha;
    }
    
    /**
     * Set recaptcha
     * @param string $recaptcha
     */
    function setRecaptcha($recaptcha)
    {
        $this->recaptcha = $recaptcha;
    }
    
    /**
     * Get recaptcha
     * @return \Epsoftware\PerfilBundle\Entity\Profile
     */
    function getProfile()
    {
        return $this->profile;
    }
    
    /**
     * Set profile
     * @param \Epsoftware\PerfilBundle\Entity\Profile $profile
     */
    function setProfile(Profile $profile)
    {
        $this->profile = $profile;
    }
    
    /**
     * Get image
     * 
     * @return \Epsoftware\PerfilBundle\Entity\ImageUser
     */
    function getImage()
    {
        return $this->image;
    }
    /**
     * Set image
     * @param ImageUser $image
     * @return \Epsoftware\UserBundle\Entity\User
     */
    function setImage(ImageUser $image)
    {
        $this->image = $image;
        
        return $this;
    }

        
    public function equals(AdvancedUserInterface $user)
    {
        return $this->getId() == $user->getId();
    }
    
    public function eraseCredentials() {
        $this->plainPassword = null;
    }

    public function isAccountNonExpired() {
        return $this->getIsAccountNonExpired();
    }

    public function isAccountNonLocked() {
        return $this->getIsAccountNonLocked();
    }

    public function isCredentialsNonExpired() {
        return $this->getIsCredentialNonExpired();
    }

    public function isEnabled() {
        return $this->getIsEnable();
    }

    public function serialize() {
        return serialize(array("id"=>$this->getId()));
    }

    public function unserialize($serialized) {
        $data = unserialize($serialized);
        $this->id = $data['id'];
    }

    public function getEncoderName() {
       //return "Epsoftware\UserBundle\Entity\User";
       return get_class($this);
    }
    
    public function toArray()
    {
        $user = [];
        foreach ($this as $property => $value):
            $user[$property] = $value;
        endforeach;
        return $user;
    }
}

