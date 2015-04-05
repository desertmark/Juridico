<?php

namespace Marlene\ActasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JuzgadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('direccion')
            ->add('ciudad')
            ->add('provincia')
            ->add('rama', 'choice', array('choices'=>array(
                ''=>'Seleccionar Fuero',
                'Civil y Comercial'=>'Civil y Comercial',
                'Penal'=>'Penal',
                'Laboral'=>'Laboral',
                'De Menor y de Familia'=>'De Menor y de Familia',
                'Contencioso Administrativo'=>'Contencioso Administrativo',
                )))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marlene\ActasBundle\Entity\Juzgado'
        ));
    }

    public function getName()
    {
        return 'marlene_actasbundle_juzgado';
    }
}
