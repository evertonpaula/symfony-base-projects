<?php

namespace Epsoftware\SuccessBundle\Services;
/**
 * Criando mensagem sucesso do registro
 *
 * @author tom
 */
class SuccessRegister
{
    
    private $title = "Registrar | Sucesso";
    
    private $header = "Tudo ok, parabéns pelo cadastro.";
    
    private $message = "Seu registro foi efetuado com sucesso.";
    
    private $instruction = "Em breve você receberá no e-mail as instruções de ativação de seu usuário.";
    
        
    public function __construct($title = null, $header = null, $message = null, $instruction = null )
    {
        $this->title = ($title !== null) ? $title : $this->title;
        $this->header = ($header !== null) ? $header : $this->header;
        $this->message = ($message !== null) ? $message : $this->message;
        $this->instruction = ($instruction !== null) ? $instruction : $this->instruction;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function getHearder()
    {
        return $this->header;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getInstruction()
    {
        return $this->instruction;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
    }
    
    public function getTwigParameters()
    {
        $success = [];
        foreach ($this as $property => $value):
            $success[$property] = $value;
        endforeach;
        return array("success" => $success);
    }
        
}
