<?php

namespace Epsoftware\AddressBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\PersistentCollection;


/**
 * ResponseJson
 *
 * @author tom
 */
class ResponseJsonMap
{
    
    private $contentType = "application/json";
    private $response;
    private $output = array();
    
    public function __construct()
    {
        $this->response = new Response();
        $this->response->headers->set("Content-Type",$this->contentType);
        return $this;
    }
    
    private function setOutput($content)
    {
        $this->output = $content;
    }
    
    private function setResponseContent()
    {
        return $this->response->setContent(json_encode($this->output));
    }
    
    public function getJsonMap($object)
    {
        $jsonMap = []; 
        foreach ($object->getAddress() as $address):
            $arr['longitude'] = $address->getLongitude();
            $arr['latitute'] = $address->getLatitude();
            $arr['address'] = $address->getGoogleFormat();
            $arr['categoria'] = $address->getCategoria()->getCategoria();
            $arr['cep'] = $address->getCep();
            array_push($jsonMap, $arr);
        endforeach;
        $this->setOutput($jsonMap);
        $this->setResponseContent($jsonMap);
        return $this->response;
    }
}
