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
     * @var string $titulo
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;
    
    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=1000)
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
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\TipoSolicitud", inversedBy="tipoSolicitudHijas")
     */
    private $tipoSolicitudPadre;

    /**
     * @var string $tipoSolicitudHijas
     *
     * @ORM\OneToMany(targetEntity="MiCiudad\ModeloBundle\Entity\TipoSolicitud", mappedBy="tipoSolicitudPadre")
     */
    private $tipoSolicitudHijas;
        
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
     * Set titulo
     *
     * @param string $titulo
     * @return TipoSolicitud
     */
    public function setTitulo($titulo)
    {
    	$this->titulo = $titulo;
    
    	return $this;
    }
    
    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
    	return $this->titulo;
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
     * @return \MiCiudad\ModeloBundle\Entity\Formulario
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
     * Set tipoSolicitudHijas
     *
     * @param string $tipoSolicitudHijas
     * @return TipoSolicitud
     */
    public function setTipoSolicitudHijas($tipoSolicitudHijas)
    {
    	$this->tipoSolicitudHijas = $tipoSolicitudHijas;
    
    	return $this;
    }
    
    /**
     * Get tipoSolicitudHijas
     *
     * @return array
     */
    public function getTipoSolicitudHijas()
    {
    	return $this->tipoSolicitudHijas;
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
    
    public function __ToString(){
    	return $this->getDescripcion();
    }
}
