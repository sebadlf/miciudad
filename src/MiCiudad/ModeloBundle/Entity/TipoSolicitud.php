<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\TipoSolicitud
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\TipoSolicitudRepository")
 */
class TipoSolicitud
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
     * @var string $icono
     *
     * @ORM\Column(name="icono", type="string", length=1000)
     */
    private $icono;

    /**
     * @var string $tipoSolicitudPadre
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\TipoSolicitud")
     */
    private $tipoSolicitudPadre;

    /**
     * @var string $formulario
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Formulario")
     */
    private $formulario;
    
    
    /**
     * @var string $area
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Area")
     */
    private $area;

    /**
     * @var string $mapa
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Mapa")
     */
    private $mapa;


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
     * @return TipoSolicitud
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
     * Set icono
     *
     * @param string $icono
     * @return TipoSolicitud
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;
    
        return $this;
    }

    /**
     * Get icono
     *
     * @return string 
     */
    public function getIcono()
    {
        return $this->icono;
    }
    
    /**
     * Set formulario
     *
     * @param string $formulario
     * @return TipoSolicitud
     */
    public function setFormulario($formulario)
    {
    	$this->formulario = $formulario;
    
    	return $this;
    }
    
    /**
     * Get formulario
     *
     * @return Formulario
     */
    public function getFormulario()
    {
    	return $this->formulario;
    }    

    /**
     * Set tipoSolicitudPadre
     *
     * @param string $tipoSolicitudPadre
     * @return TipoSolicitud
     */
    public function setTipoSolicitudPadre($tipoSolicitudPadre)
    {
        $this->tipoSolicitudPadre = $tipoSolicitudPadre;
    
        return $this;
    }

    /**
     * Get tipoSolicitudPadre
     *
     * @return string 
     */
    public function getTipoSolicitudPadre()
    {
        return $this->tipoSolicitudPadre;
    }

    /**
     * Set area
     *
     * @param string $area
     * @return TipoSolicitud
     */
    public function setArea($area)
    {
        $this->area = $area;
    
        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set mapa
     *
     * @param string $mapa
     * @return TipoSolicitud
     */
    public function setMapa($mapa)
    {
        $this->mapa = $mapa;
    
        return $this;
    }

    /**
     * Get mapa
     *
     * @return string 
     */
    public function getMapa()
    {
        return $this->mapa;
    }
}
