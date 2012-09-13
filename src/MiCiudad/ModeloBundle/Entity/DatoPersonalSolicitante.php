<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\DatoPersonalSolicitante
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\DatoPersonalSolicitanteRepository")
 */
class DatoPersonalSolicitante
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
     * @var string $codigo
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var boolean $clave
     *
     * @ORM\Column(name="clave", type="boolean")
     */
    private $clave;

    /**
     * @var boolean $requerido
     *
     * @ORM\Column(name="requerido", type="boolean")
     */
    private $requerido;

    /**
     * @var boolean $visible
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;

    /**
     * @var string $mascara
     *
     * @ORM\Column(name="mascara", type="string", length=255)
     */
    private $mascara;

    /**
     * @var boolean $password
     *
     * @ORM\Column(name="password", type="boolean")
     */
    private $password;
    

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
     * Set codigo
     *
     * @param string $codigo
     * @return DatoPersonalSolicitante
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatoPersonalSolicitante
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
     * Set clave
     *
     * @param boolean $clave
     * @return DatoPersonalSolicitante
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    
        return $this;
    }

    /**
     * Get clave
     *
     * @return boolean 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set requerido
     *
     * @param boolean $requerido
     * @return DatoPersonalSolicitante
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
     * Set visible
     *
     * @param boolean $visible
     * @return DatoPersonalSolicitante
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    
        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set password
     *
     * @param boolean $password
     * @return DatoPersonalSolicitante
     */
    public function setPassword($password)
    {
    	$this->password = $password;
    
    	return $this;
    }
    
    /**
     * Get password
     *
     * @return boolean
     */
    public function getPassword()
    {
    	return $this->password;
    }
    
    /**
     * Set mascara
     *
     * @param string $mascara
     * @return DatoPersonalSolicitante
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
    
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string 
     */
    public function getMascara()
    {
        return $this->mascara;
    }
}
