<?php

namespace Marlene\ActasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cliente')
            ->add('actuacion','choice', array(
                'label' => 'Caracter de actuacion', 
                'choices' => array('Actor' => 'Actor', 'Demandado' => 'Demandado', 'Tercero interesado' => 'Tercero interesado'
                    )))
            ->add('fecha','text')          
            ->add('abogado')
            ->add('abogadoContraparte')
            ->add('juzgado')
            ->add('detalle')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marlene\ActasBundle\Entity\Actas'
        ));
    }

    public function getName()
    {
        return 'marlene_actasbundle_actas';
    }
}
