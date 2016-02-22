<?php

namespace Epsoftware\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UploadImageUser extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, array("required" => true))
                ->add('submit', SubmitType::class,array("label" => "upload"))
                ->setMethod("POST")
                ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver-> setDefaults(array(
                    'data_class' => 'Epsoftware\UserBundle\Entity\ImageUser',
                    'validation_groups' => 'upload'
                )   
            );
    }
    
    public function getName()
    {
        return "Epsoftware\UserBundle\Form\UploadImageUser";
    }
}
