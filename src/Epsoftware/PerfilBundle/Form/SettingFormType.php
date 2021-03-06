<?php

namespace Epsoftware\PerfilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SettingFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('theme', EntityType::class, array(
                        'class' => 'PerfilBundle:Theme',
                        'choice_label' => 'skin',
                    ))
                ->add('menuNoCollapsed', CheckboxType::class)
                ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\PerfilBundle\Entity\Setting',
                        )
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\PerfilBundle\Form\SettingFormType";
    }
}
