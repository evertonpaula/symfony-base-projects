<?php

namespace Epsoftware\PerfilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImageFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class)
                ->add('submit', SubmitType::class,array("label" => "salvar"))
                ->setMethod("POST")
                ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\PerfilBundle\Entity\ImageUser',
                            'validation_groups' => array('upload', 'image')
                        )
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\PerfilBundle\Form\ImageFormType";
    }
}
