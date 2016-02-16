<?php

namespace Epsoftware\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserPermissionsFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('permission', EntityType::class,array("placeholder" => "Permisseõs do usuário", 
                "class" => "UserBundle:Permission","choice_label" => "role", "multiple" => "multiple", "expanded"=> true))
               ->add('submit', SubmitType::class, array('label' => 'salvar'))
               ->setMethod("POST")
               ->getForm(); 
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\UserBundle\Entity\User',
                            'validation_groups' => 'permission'
                        )
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\UserBundle\Form\UserPermissionsFormType";
    }
}
