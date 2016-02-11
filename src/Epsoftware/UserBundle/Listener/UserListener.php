<?php

namespace Epsoftware\UserBundle\Listener;

use Epsoftware\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Description of UserListener
 *
 * @author tom
 */
class UserListener
{
    
    /**
     * EncoderPassword
     * @var Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    private $encoderFactory;
    
    /**
     *  Function para setar informações antes do insert
     * @param Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof User):
            $this->handleEventInsert($entity);
        endif;
    }
    
    /**
     *  Function para setar informações antes do insert
     * @param Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof User):
            $this->handleEventUpdate($entity);
            $args->setNewValue('password', $entity->getPassword());
        endif;
    }
    
    public function setEncoder(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }
    
    /**
     * Set password with encoder
     * 
     * @param Epsoftware\UserBundle\Entity\User $user
     */
    private function handleEventInsert(User $user)
    {
        if($this->encoderFactory):
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->setUri(str_replace(array("?","/", "$2y$12$"), "_", $encoder->encodePassword($user->getEmail(), $user->getSalt())));
        else:
            throw new \Exception('Erro fatal, $this->encoder nao esta setado');
        endif;
    }
    
    /**
     * Set password with encoder
     * 
     * @param Epsoftware\UserBundle\Entity\User $user
     */
    private function handleEventUpdate(User $user)
    {
        if($this->encoderFactory):
            $plainPassword = $user->getPlainPassword();
            if(!empty($plainPassword)):
                $encoder = $this->encoderFactory->getEncoder($user);
                $user->setPassword($encoder->encodePassword($plainPassword, $user->getSalt()));
                $user->eraseCredentials();
            endif;
        else:
            throw new \Exception('Erro fatal, $this->encoder nao esta setado');
        endif;  
    }
}
