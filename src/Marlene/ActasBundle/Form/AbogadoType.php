<?php

namespace Marlene\ActasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AbogadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cUIT','text', array('label'=>'CUIT'))
            ->add('apellido')
            ->add('nombre')
            ->add('telefono','text')
            ->add('email')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marlene\ActasBundle\Entity\Abogado'
        ));
    }

    public function getName()
    {
        return 'marlene_actasbundle_abogado';
    }
}
