<?php

namespace Epsoftware\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TermsUser
 *
 * @ORM\Table(name="terms_user")
 * @ORM\Entity(repositoryClass="Epsoftware\UserBundle\Repository\TermsUserRepository")
 */
class TermsUser
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
     * @ORM\Column(name="title", type="string", length=100)
    */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return TermsUser
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
        
    public function getTitle()
    {
        return $this->title;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }
    
    public function toArray()
    {
        $terms = [];
        foreach ($this as $property => $value):
            $terms[$property] = $value;
        endforeach;
        return $terms;
    }
}

