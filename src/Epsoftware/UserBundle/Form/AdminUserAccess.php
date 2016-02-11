<?php

namespace Epsoftware\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminUserAccess extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('isEnable', CheckboxType::class, array("required" => false))
                ->add('isAccountNonExpired', CheckboxType::class, array("required" => false))
                ->add('isAccountNonLocked', CheckboxType::class, array("required" => false))
                ->add('isCredentialNonExpired', CheckboxType::class , array("required" => false))
                ->add('submit', SubmitType::class,array("label" => "salvar"))
                ->setMethod("POST")
                ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver-> setDefaults(array(
                    'data_class' => 'Epsoftware\UserBundle\Entity\User',
                )   
            );
    }
    
    public function getName()
    {
        return "Epsoftware\UserBundle\Form\AdminUserAccess";
    }
}
