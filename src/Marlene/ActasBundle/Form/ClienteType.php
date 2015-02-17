<?php

namespace Marlene\ActasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dNI')
            ->add('apellido')
            ->add('nombre')
            ->add('domicilio')
            ->add('telefono')
            ->add('email')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marlene\ActasBundle\Entity\Cliente'
        ));
    }

    public function getName()
    {
        return 'marlene_actasbundle_cliente';
    }
}
