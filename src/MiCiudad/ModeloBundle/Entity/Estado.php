<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\Estado
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\EstadoRepository")
 */
class Estado
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
     * @var \MiCiudad\ModeloBundle\Entity\SolicitudEstado
     *
     * @ORM\OneToMany(targetEntity="SolicitudEstado", mappedBy="estado")
     */
    protected $solicitudesEstado;
    
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
     * @return Estado
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
     * Set solicitudEstados
     *
     * @param string $solicitudesEstado
     * @return Formulario
     */
    public function setSolicitudesEstado($solicitudesEstado)
    {
    	$this->solicitudesEstado = $solicitudesEstado;
    
    	return $this;
    }
    
    /**
     * Get solicitudesEstado
     *
     * @return array
     */
    public function getSolicitudesEstado()
    {
    	return $this->solicitudesEstado;
    }
}
