<?php

namespace Epsoftware\PerfilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfileFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nome', TextType::class)
                ->add('sobrenome', TextType::class)
                ->add('dtNascimento', DateType::class, array("widget"=> "single_text", "html5"=> false,"format"=>"dd/M/yyyy", "invalid_message" => "A data de nascimento não é válida."))
                ->add('cpf', TextType::class)
                ->add('telefone', TextType::class, array("required"=>false))
                ->add('celular', TextType::class, array("required"=>false))
                ->add('genero', ChoiceType::class, array("placeholder"=> "Escolha o genero", "choices" => array("Masculino"=> 0, "Feminino"=> 1)))
                ->add('profissao', EntityType::class, array("placeholder" => "Escolha a profissao", "class" => "PerfilBundle:Profissao","choice_label" => "profissao"))
                ->add('descricao', TextareaType::class, array("required"=>false))
                ->add('submit', SubmitType::class,array("label" => "salvar"))
                ->setMethod("POST")
                ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\PerfilBundle\Entity\Profile',
                            'validation_groups' => 'profile'
                        )   
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\PerfilBundle\Form\ProfileFormType";
    }
}
