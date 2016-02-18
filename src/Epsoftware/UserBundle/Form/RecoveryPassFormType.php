<?php

namespace Epsoftware\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecoveryPassFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('email', EmailType::class) 
               ->add('submit', SubmitType::class, array('label' => 'Enviar'))
               ->setMethod("POST")
               ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\UserBundle\Entity\User',
                            'validation_groups' => 'recovery_pass',
                        )
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\UserBundle\Form\RecoveryPassFormType";
    }
}
