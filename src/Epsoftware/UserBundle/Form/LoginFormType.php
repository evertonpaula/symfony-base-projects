<?php

namespace Epsoftware\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('username', TextType::class, array("required"=>true))
                ->add('plainPassword', PasswordType::class, array("required"=>true))
                ->add('rememberMe',CheckboxType::class, array("required"=>false))
                ->add('submit', SubmitType::class, array('label' => 'Entrar'))
                ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\UserBundle\Entity\User',
                            'validation_groups' => 'login',
                        )
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\UserBundle\Form\LoginFormType";
    }
}
