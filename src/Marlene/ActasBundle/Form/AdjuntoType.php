<?php

namespace Marlene\ActasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdjuntoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('acta')
            ->add('path','file',array('label'=>'Seleccione un archivo'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marlene\ActasBundle\Entity\Adjunto'
        ));
    }

    public function getName()
    {
        return 'marlene_actasbundle_adjunto';
    }
}
