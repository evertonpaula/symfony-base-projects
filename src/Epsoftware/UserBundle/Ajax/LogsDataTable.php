<?php

namespace Epsoftware\UserBundle\Ajax;

use Epsoftware\MensageriaBundle\Services\ApiDataTable;

/**
 * Description of UserDataTable
 *
 * @author tom
 */
class LogsDataTable extends ApiDataTable
{
    public function __construct(array $logs) {
        parent::__construct($logs);
    }

    public function setSource($source = "DataTable", array $extraParameters =  null) {
        $dataSource = [];
        foreach($this->data as $logs):
            $data['created'] = $logs->getCreated()->format("d-m-Y H:i:s");
            $data['login'] = ($logs->getUser()) ? $logs->getUser()->getUsername() : "Sem Identificação";
            $data['name'] = ($logs->getUser()) 
                                ? ($logs->getUser()->getProfile()) 
                                    ? $logs->getUser()->getProfile()->getNome() . " ". $logs->getUser()->getProfile()->getSobrenome() 
                                    : 'Sem perfil' 
                                : "Sem Identificão";    
            $data['local'] = $logs->getLocal();
            $data['acao'] = $logs->getAcao();
            $data['descricao'] = $logs->getObservacao();
            array_push($dataSource, $data);
        endforeach;
        
        $this->setOutputDataTable($dataSource, $source);
        return $this->setResponseContent();
    }
}
