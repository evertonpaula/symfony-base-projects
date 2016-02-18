<?php

namespace Epsoftware\UserBundle\Services;

use Swift_Mailer;
use Swift_Message;
use Twig_Environment;
use Exception;

/**
 * MailService
 * Serviços de envios de mensagens por e-mail
 *
 * @author tom
 */
class MailService
{

    /**
     *
     * @var \Swift_Mailer 
     */
    private $mail;
    
    /**
     *
     * @var \Swift_Message 
     */
    private $message;
    
    /**
     * @var string from
     */
    private $from = "epsoftware@epsoftware.com.br";
    
    /**
     *
     * @var \Twig_Environment 
    */
    private $twig;
    
    
    public function __construct(Swift_Mailer $mail)
    {
        $this->mail = $mail;
        $this->message = Swift_Message::newInstance();
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function setMessage(Swift_Message $message)
    {
        $this->message = $message;
    }
    
    public function setTwigEnvironment(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    public function createEmail($subject, array $to, $template, array $parameters = array())
    {
        try{
            $this->getMessage()
                  ->setSubject($subject)
                  ->setFrom($this->from)
                  ->setTo($to)
                  ->setBody($this->twig->render($template, $parameters));
        }catch(Exception $ex){
            throw  new Exception($ex);
        }
    }
    
    public function sendEmail()
    {
        try{
            if(!$this->mail->send($this->message)):
                throw  new Exception("Falha ao enviar e-mail");
            endif;
        }catch(Exception $ex){
            throw  new Exception($ex);
        }
    }
}
