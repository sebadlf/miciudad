<?php

namespace MiCiudad\ModeloBundle\Entity;

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
     * @var string $tipoSolicitud
     *
     * @ORM\Column(name="tipoSolicitud", type="string", length=255)
     */
    private $tipoSolicitud;

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
     * @var string $dispositivo
     *
     * @ORM\Column(name="dispositivo", type="string", length=255)
     */
    private $dispositivo;

    /**
     * @var string $solicitante
     *
     * @ORM\Column(name="solicitante", type="string", length=255)
     */
    private $solicitante;

    /**
     * @var string $zona
     *
     * @ORM\Column(name="zona", type="string", length=255)
     */
    private $zona;

    /**
     * @var string $idioma
     *
     * @ORM\Column(name="idioma", type="string", length=255)
     */
    private $idioma;


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
     * @param string $tipoSolicitud
     * @return Solicitud
     */
    public function setTipoSolicitud($tipoSolicitud)
    {
        $this->tipoSolicitud = $tipoSolicitud;
    
        return $this;
    }

    /**
     * Get tipoSolicitud
     *
     * @return string 
     */
    public function getTipoSolicitud()
    {
        return $this->tipoSolicitud;
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
     * @param string $dispositivo
     * @return Solicitud
     */
    public function setDispositivo($dispositivo)
    {
        $this->dispositivo = $dispositivo;
    
        return $this;
    }

    /**
     * Get dispositivo
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
     * @param string $solicitante
     * @return Solicitud
     */
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;
    
        return $this;
    }

    /**
     * Get solicitante
     *
     * @return string 
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set zona
     *
     * @param string $zona
     * @return Solicitud
     */
    public function setZona($zona)
    {
        $this->zona = $zona;
    
        return $this;
    }

    /**
     * Get zona
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
     * @param string $idioma
     * @return Solicitud
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;
    
        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }
}
