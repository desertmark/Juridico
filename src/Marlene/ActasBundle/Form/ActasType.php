<?php

namespace Marlene\ActasBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Marlene\ActasBundle\Entity\Juzgado;
use Marlene\ActasBundle\Entity\Rama;

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
            ->add('fecha','date', array('widget' =>'single_text'))
            ->add('auto')          
            ->add('rama','choice', array('label'=>'FUERO', 'mapped' => false, 'choices' => array(
                ''=>'Seleccionar Fuero',
                'Civil y Comercial'=>'Civil y Comercial',
                'Penal'=>'Penal',
                'Laboral'=>'Laboral',
                'De Menor y de Familia'=>'De Menor y de Familia',
                'Contencioso Administrativo'=>'Contencioso Administrativo',
                )))
            ->add('juzgado')
            ->add('abogadoContraparte')
            ->add('detalle', 'textarea', array('attr'=>array('class'=>'tinymce')))
            ->add('descripcion', 'textarea', array('attr'=>array('class'=>'tinymce')))
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
