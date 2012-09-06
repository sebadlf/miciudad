<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\Formulario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\FormularioRepository")
 */
class Formulario
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
     * @var \MiCiudad\ModeloBundle\Entity\CampoExtendido
     *
     * @ORM\OneToMany(targetEntity="CampoExtendido", mappedBy="formulario")
     */
    protected $camposExtendidos;    

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
     * @return Formulario
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
     * Set camposExtendidos
     *
     * @param string $camposExtendidos
     * @return Formulario
     */
    public function setCamposExtendidos($camposExtendidos)
    {
    	$this->camposExtendidos = $camposExtendidos;
    
    	return $this;
    }
    
    /**
     * Get camposExtendidos
     *
     * @return array
     */
    public function getCamposExtendidos()
    {
    	return $this->camposExtendidos;
    }
    
    public function __ToString(){
    	return $this->getDescripcion();
    }
    
}
