<?php

namespace Epsoftware\DashboardBundle\Services;

use Twig_Environment;

/**
 * Paginator
 *
 * @author tom
 */
class Paginator extends \Twig_Extension
{
    
    /** @var int */
    private $limit;
    
    /** @var int */
    private $size;
    
    /** @var int */
    private $offset;
    
    /** @var class_string */
    private $class;
    
    /** @var atual */
    private $method;
    
    /** @var atual */
    private $atual;
    
    /**
     * Twig
     * @var Twig_Environment
    */
    private $twig;
    
    /**
     * 
     * @param type $class
     * @param type $limit
     * @param type $offset
     * @param type $atual
     * @return \Epsoftware\DashboardBundle\Services\Paginator
     */
    public function __construct($class = null, $limit= null, $offset = null, $method = null, $atual = 1)
    {
        $this->class = $class;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->atual = $atual;
        $this->method = $method;
    }
    
    function getLimit() {
        return $this->limit;
    }

    function getSize() {
        return $this->size;
    }

    function getOffset() {
        return $this->offset;
    }

    function getClass() {
        return $this->class;
    }

    function getMethod() {
        return $this->method;
    }

    function getAtual() {
        return $this->atual;
    }

    function setLimit($limit) {
        $this->limit = $limit;
    }

    function setSize($size) {
        $this->size = $size;
    }

    function setOffset($offset) {
        $this->offset = $offset;
    }

    function setClass(class_string $class) {
        $this->class = $class;
    }

    function setMethod(atual $method) {
        $this->method = $method;
    }

    function setAtual(atual $atual) {
        $this->atual = $atual;
    }
    
    public function setTwigEnvironment(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
          
    public function getName()
    {
        return "Paginator";
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('paginator', array($this, 'getPaginator')),
        );
    }
    
    public function getPaginator(Paginator $object)
    {
        if($this->twig):
            return $this->twig->render("DashboardBundle:Paginator:paginator.html.twig", array("object" => $object));
        endif;
        
        throw new \Exception('Erro ao tentar carregar o menu principal, renderizador $this->twig não está setado');
    }
}
