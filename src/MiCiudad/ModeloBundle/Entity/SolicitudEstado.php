<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\SolicitudEstado
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\SolicitudEstadoRepository")
 */
class SolicitudEstado
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
     * @var string $solicitud
     *
     * @ORM\Column(name="solicitud", type="string", length=255)
     */
    private $solicitud;

    /**
     * @var string $estado
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var \DateTime $fecha
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;


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
     * Set solicitud
     *
     * @param string $solicitud
     * @return SolicitudEstado
     */
    public function setSolicitud($solicitud)
    {
        $this->solicitud = $solicitud;
    
        return $this;
    }

    /**
     * Get solicitud
     *
     * @return string 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return SolicitudEstado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return SolicitudEstado
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }
}
