<?php

namespace MiCiudad\ModeloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampoExtendidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('requerido', null, array("required" => false))
            ->add('orden')
            ->add('estiloCss', null, array("required" => false))
            ->add('formulario')
            ->add('tipoDato')
            ->add('tipoControl')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MiCiudad\ModeloBundle\Entity\CampoExtendido'
        ));
    }

    public function getName()
    {
        return 'miciudad_modelobundle_campoextendidotype';
    }
}
