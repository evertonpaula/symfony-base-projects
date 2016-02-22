<?php

namespace Epsoftware\MensageriaBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\SubmitButton;

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
    private $keyUploadError = "upload_error";
    private $keyWarning = "warning";
    private $keyInfo = "info";
    private $keyMessage = "message";
    private $callback = "callback";
    private $response;
    private $output = array();
    private $serializer;
    
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->response = new Response();
        $this->response->headers->set("Content-Type",$this->contentType);
        return $this;
    }
    
    private function setOutput($key, $message, $keyContent = null)
    {
        $this->output[$key] = true; 
        if($keyContent):
            $this->output[$keyContent] = $message;
        else:
            $this->output[$this->keyMessage] = $message;
        endif;
        
    }
    
    private function setResponseContent()
    {
        return $this->response->setContent(json_encode($this->output));
    }
    
    public function getFormErrors(Form $form, array $parameters = null)
    {
        $this->setOutput($this->keyError, $this->serializer->serialize($form->getErrors(true, true), 'json'));
        if($parameters):
            $this->setOutput($this->callback, $parameters);
        endif;
        return $this->setResponseContent();
    }
    
    public function getErrors($message, array $parameters = null)
    {
        $this->setOutput($this->keyError, $message);
        if($parameters):
            $this->setOutput($this->callback, $parameters);
        endif;
        return $this->setResponseContent();
    }
    
    public function getWarning($message, array $parameters = null)
    {
        $this->setOutput($this->keyWarning, $message);
        if($parameters):
            $this->setOutput($this->callback, $parameters);
        endif;
        return $this->setResponseContent();
    }
    
    public function getInfo($message, array $parameters = null)
    {
        $this->setOutput($this->keyInfo, $message);
        if($parameters):
            $this->setOutput($this->callback, $parameters);
        endif;
        return $this->setResponseContent();
    }
    
    public function getSuccess($message, array $parameters = null )
    {
        $this->setOutput($this->keySuccess, $message);
        if($parameters):
          $this->setCallbackParametersExtra($parameters);
        endif;
        return $this->setResponseContent();
    }

    private function setCallbackParametersExtra(array $parameters)
    {
        foreach ($parameters as $key => $value):
            $this->setOutput($this->callback, $value, $key);
        endforeach;
    }
    
    public function uploadGetErrors(Form $form)
    {
        $local_errors[$this->callback] = array();
        foreach ($form->getIterator() as $key => $child) {

            foreach ($child->getErrors() as $error){
                array_push($local_errors[$this->callback], $error->getMessage());
            }

            if (count($child->getIterator()) > 0) {
                if (!$child instanceof SubmitButton){
                    array_push($local_errors[$this->callback], $this->uploadGetErrors($child));
                }
            }
        }
        $this->setOutput($this->keyUploadError, $this->serializer->serialize($local_errors, "json"));
        return $this->setResponseContent();
    }
}
