<?php

namespace Epsoftware\MensageriaBundle\Services;

use Twig_Environment;
use Symfony\Component\HttpFoundation\Response;

/**
 * Criando mensagem sucesso do registro
 *
 * @author tom
 */
class RedirectMessage
{
    /**
     * Constantes
     */
    const SUCCESS = 1;
    const ERROR = 0;
    
    /** @var int */
    private $code;
    
    /** @var string */
    private $title;
    
    /** @var string */
    private $header;
    
    /** @var string */
    private $message;
    
    /** @var string */
    private $instruction;
    
    /** @var array */
    private $parameters;
    
    /** @var string */
    private $erroTemplate = "::fail.html.twig";
    
    /** @var string */
    private $successTemplate = "::success.html.twig";
    
    /** @var \Twig_Environment */
    private $twig;
    
    /**
     * Set code
     * @param integer $code
     * @return \Epsoftware\MensageriaBundle\Services\RedirectMessage
     */
    public function setCode($code)
    {
        $this->code = $code;
        
        return $this;
    }
    
    public function render($header, $message, $instruction, $type = self::SUCCESS, array $parameters = [])
    {
        $this->header = $header;
        $this->message = $message;
        $this->instruction = $instruction;
        $this->parameters = $parameters;
        
        if($type === self::SUCCESS):
            $this->title = "Sucesso";
            return $this->success();
        endif;
        
        $this->title = "Erro";
        return $this->error();
    }
    
    public function setTwigEnvironment(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    private function paratrize()
    {
        return array(
            "code" => $this->code,
            "title" => $this->title,
            "header" => $this->header,
            "message" => $this->message,
            "instruction" => $this->instruction,
        );
    }
    
    private function success()
    {
        $response = new Response();
        return $response->setContent($this->twig->render($this->successTemplate, $this->paratrize()));
    }
    
    private function error()
    {
        $response = new Response();
        return $response->setContent($this->twig->render($this->erroTemplate, $this->paratrize()));
    }
    
}
