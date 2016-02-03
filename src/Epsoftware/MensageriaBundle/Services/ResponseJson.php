<?php

namespace Epsoftware\MensageriaBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\Serializer\Serializer;

/**
 * ResponseJson
 *
 * @author tom
 */
class ResponseJson
{
    
    private $contentType = "application/json";
    private $keySuccess = "success";
    private $keyError = "error";
    private $keyWarning = "warning";
    private $keyInfo = "info";
    private $keyMessage = "message";
    private $response;
    private $output;
    private $serializer;
    
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->response = new Response();
        $this->response->headers->set("Content-Type",$this->contentType);
        return $this;
    }
    
    private function setOutput($key, $message)
    {
        $this->output = array($key => true, $this->keyMessage => $message);
    }
    
    private function setResponseContent()
    {
        return $this->response->setContent(json_encode($this->output));
    }
    
    public function getErrors(Form $form)
    {
        $this->setOutput($this->keyError, $this->serializer->serialize($form->getErrors(true, true), 'json'));
        return $this->setResponseContent();
    }
    
    public function getWarning($message)
    {
        $this->setOutput($this->keyWarning, $message);
        return $this->setResponseContent();
    }
    
    public function getInfo($message)
    {
        $this->setOutput($this->keyInfo, $message);
        return $this->setResponseContent();
    }
    
    public function getSuccess($message)
    {
        $this->setOutput($this->keySuccess, $message);
        return $this->setResponseContent();
    }

}
