<?php

namespace MiCiudad\ModeloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DispositivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dispositivo')
            ->add('version')
            ->add('detalle')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MiCiudad\ModeloBundle\Entity\Dispositivo',
        	'csrf_protection'   => false
        ));
    }

    public function getName()
    {
        return 'miciudad_modelobundle_dispositivotype';
    }
}
