<?php

namespace Epsoftware\MensageriaBundle\Services;

use Symfony\Component\HttpFoundation\Response;

/**
 * ResponseJson
 *
 * @author tom
 */
abstract class ApiDataTable
{
    
    private $contentType = "application/json";
    private $keySuccess = "success";
    private $keyError = "error";
    private $keyWarning = "warning";
    private $keyInfo = "info";
    private $keyMessage = "message";
    private $response;
    protected $data;
    private $output = array();
    
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->response = new Response();
        $this->response->headers->set("Content-Type",$this->contentType);
        return $this;
    }
    
    public function setSuccess($message)
    {
        $this->setOutput($this->keySuccess, $message);
        return $this;
    }
    
    public function setError($message)
    {
        $this->setOutput($this->keyError, $message);
        return $this;
    }
    
    public function setWarning($message)
    {
        $this->setOutput($this->keyWarning, $message);
        return $this;
    }
    
    public function setInfo($message)
    {
        $this->setOutput($this->keyInfo, $message);
        return $this;
    }
    
    private function setOutput($key, $message)
    {
        $this->output[$key] = true; 
        $this->output[$this->keyMessage] = $message;
    }
    
    protected function setOutputDataTable(array $data, $key)
    {
        $this->output[$key] = $data;
    }
    
    protected function setOutputDataTableMandatory($key, $data)
    {
        $this->setOutputDataTableMandatory("draw", 1);
        $this->setOutputDataTableMandatory("recordsTotal", count($this->data));
        $this->setOutputDataTableMandatory("recordsFiltered", count($this->data));
        $this->output[$key] = $data;
    }
    
    abstract public function setSource($source = null, array $extraParameters =  null);

    protected function setResponseContent()
    {
        return $this->response->setContent(json_encode($this->output));
    }
}
