<?php

namespace Epsoftware\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class RegisterFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('username', TextType::class)
                ->add('email', EmailType::class)
                ->add('plainPassword', RepeatedType::class, array( 'type' => PasswordType::class, 'invalid_message' => 'As senhas não conferem'))
                ->add('agree', CheckboxType::class)
                ->add('recaptcha', EWZRecaptchaType::class)
                ->add('submit', SubmitType::class, array('label' => 'Registrar'))
                ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\UserBundle\Entity\User',
                            'validation_groups' => 'registration'
                        )
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\UserBundle\Form\RegisterFormType";
    }
}
