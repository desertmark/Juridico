<?php

namespace Marlene\ActasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class ActasFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'filter_number_range')
            ->add('cliente', 'filter_entity', array('class'=>'MarleneActasBundle:Cliente'))
            ->add('abogadoConrtaparte', 'filter_entity', array('class'=>'MarleneActasBundle:Abogado'))
            ->add('juzgado', 'filter_entity', array('class'=>'MarleneActasBundle:Juzgado'))
            ->add('fecha', 'filter_date_range',array('left_date_options'=>array('widget'=>'single_text'),'right_date_options'=>array('widget'=>'single_text')))
            ->add('detalle', 'filter_text')
        ;

        $listener = function(FormEvent $event)
        {
            // Is data empty?
            foreach ($event->getData() as $data) {
                if(is_array($data)) {
                    foreach ($data as $subData) {
                        if(!empty($subData)) return;
                    }
                }
                else {
                    if(!empty($data)) return;
                }
            }

            $event->getForm()->addError(new FormError('Filter empty'));
        };
        $builder->addEventListener(FormEvents::POST_BIND, $listener);
    }

    public function getName()
    {
        return 'marlene_actasbundle_actasfiltertype';
    }
}
