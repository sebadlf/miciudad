<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\CampoExtendidoOpcion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\CampoExtendidoOpcionRepository")
 */
class CampoExtendidoOpcion
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
     * @var string $campoExtendido
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\CampoExtendido", inversedBy="campoExtendidoOpciones")
     */
    private $campoExtendido;
    
    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;


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
     * Set campoExtendido
     *
     * @param string $campoExtendido
     * @return CampoExtendido
     */
    public function setCampoExtendido($campoExtendido)
    {
    	$this->campoExtendido = $campoExtendido;
    
    	return $this;
    }
    
    /**
     * Get campoExtendido
     *
     * @return string
     */
    public function getCampoExtendido()
    {
    	return $this->campoExtendido;
    }
    
    
    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return CampoExtendidoOpcion
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
}
