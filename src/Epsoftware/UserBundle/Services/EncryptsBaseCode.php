<?php

namespace Epsoftware\UserBundle\Services;

use Twig_Environment;
/**
 * Encrypt Values
 * 
 * @author tom
 */
class EncryptsBaseCode extends \Twig_Extension
{

    /**
     *
     * @var string 
     */
    private $salt = "de21f6d7b34fb624189bd67f72d1647b";
    
    /**
     *
     * @var Twig_Environment 
     */
    private $twig;
    
    public function __construct(Twig_Environment $twig = null)
    {
        $this->twig = $twig;
    }
    
    public function encrypt($value)
    {
        return base64_encode($value.$this->salt);
    }
    
    public function descrypt($value)
    {
        return str_replace($this->salt, "", base64_decode($value));
    }
    
    public function getName()
    {
        return "EncryptsBaseCode";
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('encrypt', array($this, 'encrypt')),
        );
    }
}
