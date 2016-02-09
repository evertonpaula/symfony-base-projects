<?php

namespace Epsoftware\AddressBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Epsoftware\AddressBundle\Entity\Estado;
use Symfony\Component\Form\FormInterface;

class AddressFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cep', TextType::class, array("attr" => array("class"=> "cep form-control")))
                ->add('categoria', EntityType::class, array("placeholder" => "Categoria", "class" => "AddressBundle:Categoria","choice_label" => "categoria"))
                ->add('logradouro', TextType::class, array("attr" => array("class"=> "txtLogradouro form-control")))
                ->add('numero', TextType::class, array("required"=>false))
                ->add('complemento', TextType::class, array("required"=>false))
                ->add('bairro', TextType::class, array("required"=>false, "attr" => array("class"=> "bairro form-control")))
                ->add('pais', EntityType::class, array("class" => "AddressBundle:Pais","choice_label" => "pais", "attr" => array("class" => "address_form_pais form-control")))
                ->add('estado', EntityType::class, array("placeholder" => "Estados", "class" => "AddressBundle:Estado", "choice_label" => "estado", "attr" => array("class"=> "address_form_estado form-control")))
                ->add('cidade', EntityType::class, array("placeholder" => "Cidades", "class" => "AddressBundle:Cidade", "choice_label" => "cidade", "attr" => array("class"=> "address_form_cidade form-control")))
                ->add('longitude', HiddenType::class, array("attr" => array("class"=> "longitude")))
                ->add('latitude', HiddenType::class, array("attr" => array("class"=> "latitude")))
                ->add('googleFormat', HiddenType::class, array("attr" => array("class"=> "googleFormat")))
                ->add('submit', SubmitType::class,array("label" => "salvar"))
                ->setMethod("POST")
                ->getForm();
        
        $formModifier = function (FormInterface $form, Estado $estado = null) {
            
            $cidades = null === $estado ? array() : $estado->getCidade();
            
            $form->add('cidade', EntityType::class, array(
                'class'       => 'AddressBundle:Cidade',
                "attr" => array("class"=> "address_form_cidade form-control"),
                'placeholder' => 'Cidades',
                'choices'     => $cidades,
                "choice_label" => "cidade",
            ));
            
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                
                $formModifier($event->getForm(), $data->getEstado(), $data->getPais());
            }
        );
        
        $builder->get('estado')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $estado = $event->getForm()->getData();
                
                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $estado);
            }
        );
    }
    
    /**
     * Get Cidaes para query_builder
     * @param EntityRepository $er
     * @return QueryBuilder 
     */
    private function getCidades(EntityRepository  $er)
    {
        return $er->createQueryBuilder('c')->where("c.cidade = :cidade")
                   ->setParameter("cidade", 'escolha a cidade'); 
    }
    
    /**
     * Get Estados para query_builder
     * @param EntityRepository $er
     * @return QueryBuilder
     */
    private function getEstados(EntityRepository  $er)
    {
        return $er->createQueryBuilder('e')->where("e.estado = :estado")
                        ->setParameter("estado", 'escolha o estado');
    }
    
    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver-> setDefaults(array(
                            'data_class' => 'Epsoftware\AddressBundle\Entity\Address',
                            'validation_groups' => 'address'
                        )   
                    );
    }
    
    public function getName()
    {
        return "Epsoftware\AddressBundle\Form\AddressFormType";
    }
}
