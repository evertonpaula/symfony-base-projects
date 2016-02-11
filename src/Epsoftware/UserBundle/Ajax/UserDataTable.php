<?php

namespace Epsoftware\UserBundle\Ajax;

use Epsoftware\MensageriaBundle\Services\ApiDataTable;
use Epsoftware\UserBundle\Services\EncryptsBaseCode;

/**
 * Description of UserDataTable
 *
 * @author tom
 */
class UserDataTable extends ApiDataTable
{
    public function __construct(array $data) {
        parent::__construct($data);
    }

    public function setSource($source = "DataTable", array $extraParameters =  null) {
        $encrypt = new EncryptsBaseCode();
        $dataSource = [];
        foreach($this->data as $user):
            $id = $encrypt->encrypt($user->getId());
            $data['name'] = ($user->getProfile()) ? $user->getProfile()->getNome() . " ". $user->getProfile()->getSobrenome() : 'Sem perfil';    
            $data['email'] = $user->getEmail();
            $data['created'] = $user->getCreated()->format("d/m/Y");
            $data['enable'] = ($user->getIsEnable()) ? "Habilidatado" : "Desesabilidatado";
            $data['locked'] = ($user->getIsAccountNonLocked()) ? "Desbloqueada" : "Bloqueada";
            $data['acountExpired'] = ($user->getIsAccountNonExpired()) ? "Ativa" : "Expirada";
            $data['credentialExpired'] = ($user->getIsCredentialNonExpired()) ? "Ativas" : "Expiradas";
            $data['action'] = 
            "<a data-url='{$extraParameters['url_profile']}/{$id}' title='Ver perfil do usuário' class='action info' href><i  class='fa fa-info-circle'></i></a>
             <a data-url='{$extraParameters['url_permissions']}/{$id}' title='Abrir área de permissões' class='action access' href><i  class='fa fa-lock'></i></a>
             <a data-url='{$extraParameters['url_logs']}/{$id}' title='Abrir área de logs' class='action logs' href><i class='fa fa-exchange'></i></a>
             <a data-url='{$extraParameters['url_delete']}/{$id}' title='Deletar usuário' class='action delete' href><i class='fa fa-trash'></i></a>";
            array_push($dataSource, $data);
        endforeach;
        
        $this->setOutputDataTable($dataSource, $source);
        return $this->setResponseContent();
    }
}
