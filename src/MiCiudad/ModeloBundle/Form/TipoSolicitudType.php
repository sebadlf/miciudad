<?php

namespace MiCiudad\ModeloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TipoSolicitudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('icono')
            ->add('tipoSolicitudPadre', null, array("required" => false))
            ->add('formulario', null, array("required" => false))
            ->add('area')
            ->add('mapa')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MiCiudad\ModeloBundle\Entity\TipoSolicitud'
        ));
    }

    public function getName()
    {
        return 'miciudad_modelobundle_tiposolicitudtype';
    }
}
