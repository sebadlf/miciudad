<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\CampoExtendido
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\CampoExtendidoRepository")
 */
class CampoExtendido
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string $tipoDato
     *
     * @ORM\Column(name="tipoDato", type="string", length=255)
     */
    private $tipoDato;

    /**
     * @var string $tipoControl
     *
     * @ORM\Column(name="tipoControl", type="string", length=255)
     */
    private $tipoControl;

    /**
     * @var boolean $requerido
     *
     * @ORM\Column(name="requerido", type="boolean")
     */
    private $requerido;

    /**
     * @var integer $orden
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;

    /**
     * @var string $estiloCss
     *
     * @ORM\Column(name="estiloCss", type="string", length=255)
     */
    private $estiloCss;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return CampoExtendido
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tipoDato
     *
     * @param string $tipoDato
     * @return CampoExtendido
     */
    public function setTipoDato($tipoDato)
    {
        $this->tipoDato = $tipoDato;
    
        return $this;
    }

    /**
     * Get tipoDato
     *
     * @return string 
     */
    public function getTipoDato()
    {
        return $this->tipoDato;
    }

    /**
     * Set tipoControl
     *
     * @param string $tipoControl
     * @return CampoExtendido
     */
    public function setTipoControl($tipoControl)
    {
        $this->tipoControl = $tipoControl;
    
        return $this;
    }

    /**
     * Get tipoControl
     *
     * @return string 
     */
    public function getTipoControl()
    {
        return $this->tipoControl;
    }

    /**
     * Set requerido
     *
     * @param boolean $requerido
     * @return CampoExtendido
     */
    public function setRequerido($requerido)
    {
        $this->requerido = $requerido;
    
        return $this;
    }

    /**
     * Get requerido
     *
     * @return boolean 
     */
    public function getRequerido()
    {
        return $this->requerido;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return CampoExtendido
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    
        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set estiloCss
     *
     * @param string $estiloCss
     * @return CampoExtendido
     */
    public function setEstiloCss($estiloCss)
    {
        $this->estiloCss = $estiloCss;
    
        return $this;
    }

    /**
     * Get estiloCss
     *
     * @return string 
     */
    public function getEstiloCss()
    {
        return $this->estiloCss;
    }
}
