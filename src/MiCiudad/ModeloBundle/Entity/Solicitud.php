<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\Solicitud
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\SolicitudRepository")
 */
class Solicitud
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
     * @var MiCiudad\ModeloBundle\Entity\TipoSolicitud $tipoSolicitud
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\TipoSolicitud")
     */
    private $tipoSolicitud;

    /**
     * @var string $numeroSolicitud
     *
     * @ORM\Column(name="numeroSolicitud", type="string", length=255)
     */
    private $numeroSolicitud;
    
    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string $foto
     *
     * @ORM\Column(name="foto", type="string", length=1000)
     */
    private $foto;

    /**
     * @var string $direccion
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string $direccionValidada
     *
     * @ORM\Column(name="direccionValidada", type="boolean")
     */
    private $direccionValidada;    
    
    /**
     * @var float $latitud
     *
     * @ORM\Column(name="latitud", type="float")
     */
    private $latitud;

    /**
     * @var float $longitud
     *
     * @ORM\Column(name="longitud", type="float")
     */
    private $longitud;

    /**
     * @var MiCiudad\ModeloBundle\Entity\Dispositivo $dispositivo
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Dispositivo")
     */
    private $dispositivo;

    /**
     * @var MiCiudad\ModeloBundle\Entity\Solicitante $solicitante
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Solicitante")
     */
    private $solicitante;

    /**
     * @var MiCiudad\ModeloBundle\Entity\Zona $zona
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Zona")
     */
    private $zona;

    /**
     * @var MiCiudad\ModeloBundle\Entity\Idioma $idioma
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Idioma")
     */
    private $idioma;

    /**
     * @var \MiCiudad\ModeloBundle\Entity\SolicitudEstado
     *
     * @ORM\OneToMany(targetEntity="SolicitudEstado", mappedBy="solicitud", cascade="all")
     */
    protected $solicitudEstados;
    
    
    public function __construct(){
    	$this->solicitudEstados = new ArrayCollection();
    } 
    
    
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
     * Set tipoSolicitud
     *
     * @param MiCiudad\ModeloBundle\Entity\TipoSolicitud $tipoSolicitud
     * @return Solicitud
     */
    public function setTipoSolicitud(MiCiudad\ModeloBundle\Entity\TipoSolicitud $tipoSolicitud)
    {
        $this->tipoSolicitud = $tipoSolicitud;
    
        return $this;
    }

    /**
     * Get tipoSolicitud
     *
     * @return MiCiudad\ModeloBundle\Entity\TipoSolicitud 
     */
    public function getTipoSolicitud()
    {
        return $this->tipoSolicitud;
    }

    /**
     * Set numeroSolicitud
     *
     * @param string $numeroSolicitud
     * @return Solicitud
     */
    public function setNumeroSolicitud($numeroSolicitud)
    {
    	$this->numeroSolicitud = $numeroSolicitud;
    
    	return $this;
    }
    
    /**
     * Get numeroSolicitud
     *
     * @return string
     */
    public function getNumeroSolicitud()
    {
    	return $this->numeroSolicitud;
    }
    
    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Solicitud
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
     * Set foto
     *
     * @param string $foto
     * @return Solicitud
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    
        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Solicitud
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set direccionValidada
     *
     * @param boolean $direccionValidada
     * @return Solicitud
     */
    public function setDireccionValidada($direccionValidada)
    {
    	$this->direccionValidada = $direccionValidada;
    
    	return $this;
    }
    
    /**
     * Get direccionValidada
     *
     * @return boolean
     */
    public function getDireccionValidada()
    {
    	return $this->direccionValidada;
    }
    
    /**
     * Set latitud
     *
     * @param float $latitud
     * @return Solicitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    
        return $this;
    }

    /**
     * Get latitud
     *
     * @return float 
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param float $longitud
     * @return Solicitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    
        return $this;
    }

    /**
     * Get longitud
     *
     * @return float 
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set dispositivo
     *
     * @param MiCiudad\ModeloBundle\Entity\Dispositivo $dispositivo
     * @return Solicitud
     */
    public function setDispositivo(\MiCiudad\ModeloBundle\Entity\Dispositivo $dispositivo)
    {
        $this->dispositivo = $dispositivo;
    
        return $this;
    }

    /**
     * Get MiCiudad\ModeloBundle\Entity\Dispositivo
     *
     * @return string 
     */
    public function getDispositivo()
    {
        return $this->dispositivo;
    }

    /**
     * Set solicitante
     *
     * @param MiCiudad\ModeloBundle\Entity\Solicitante $solicitante
     * @return Solicitud
     */
    public function setSolicitante(\MiCiudad\ModeloBundle\Entity\Solicitante $solicitante)
    {
        $this->solicitante = $solicitante;
    
        return $this;
    }

    /**
     * Get solicitante
     *
     * @return MiCiudad\ModeloBundle\Entity\Solicitante 
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set zona
     *
     * @param MiCiudad\ModeloBundle\Entity\Zona $zona
     * @return Solicitud
     */
    public function setZona(\MiCiudad\ModeloBundle\Entity\Zona $zona)
    {
        $this->zona = $zona;
    
        return $this;
    }

    /**
     * Get MiCiudad\ModeloBundle\Entity\Zona
     *
     * @return string 
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set idioma
     *
     * @param MiCiudad\ModeloBundle\Entity\Idioma $idioma
     * @return Solicitud
     */
    public function setIdioma(\MiCiudad\ModeloBundle\Entity\Idioma $idioma)
    {
        $this->idioma = $idioma;
    
        return $this;
    }

    /**
     * Get idioma
     *
     * @return MiCiudad\ModeloBundle\Entity\Idioma 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }
    
    /**
     * Set solicitudEstados
     *
     * @param array $solicitudEstados
     * @return Formulario
     */
    public function setSolicitudEstados($solicitudEstados)
    {
    	$this->solicitudEstados = $solicitudEstados;
    
    	return $this;
    }
    
    /**
     * Get solicitudEstados
     *
     * @return array
     */
    public function getSolicitudEstados()
    {
    	return $this->solicitudEstados;
    }

    
}
