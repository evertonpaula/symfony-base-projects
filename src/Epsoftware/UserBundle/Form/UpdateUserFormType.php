<?php

namespace Epsoftware\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdateUserFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('email', EmailType::class)
               ->add('plainPassword', RepeatedType::class, array( 'type' => PasswordType::class, 'invalid_message' => 'As senhas não conferem'))
               ->add('submit', SubmitType::class, array('label' => 'salvar'))
               ->setMethod("POST")
               ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\UserBundle\Entity\User',
                            'validation_groups' => 'update_user'
                        )
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\UserBundle\Form\UpdateUserFormType";
    }
}
