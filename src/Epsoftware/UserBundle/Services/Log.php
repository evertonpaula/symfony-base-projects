<?php

namespace Epsoftware\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use Epsoftware\UserBundle\Entity\Logger;
use Epsoftware\UserBundle\Entity\User;

/**
 * Log do sistema
 *
 * @author tom
 */
class Log
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;
   
    public function __construct()
    {
        return $this;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function logger($local, $action, User $user = null, $observation = null)
    {
        $log = new Logger();
        $log->setAcao($action)
            ->setLocal($local)
            ->setUser($user)
            ->setObservacao($observation);
        
        $this->em->persist($log);
        $this->em->flush($log);
    }
}
