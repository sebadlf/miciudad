<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\Solicitante
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\SolicitanteRepository")
 */
class Solicitante
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
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string $apellido
     *
     * @ORM\Column(name="apellido", type="string", length=255, nullable=true)
     */
    private $apellido;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var integer $dni
     *
     * @ORM\Column(name="dni", type="integer", nullable=true)
     */
    private $dni;

    /**
     * @var string $cuit
     *
     * @ORM\Column(name="cuit", type="string", length=13, nullable=true)
     */
    private $cuit;

    /**
     * @var string $cpf
     *
     * @ORM\Column(name="cpf", type="string", length=15, nullable=true)
     */
    private $cpf;

    /**
     * @var \DateTime $fechaNacimiento
     *
     * @ORM\Column(name="fechaNacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var string $sexo
     *
	 * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Sexo")
	 * @ORM\JoinColumn(name="sexo_id", referencedColumnName="id", nullable=true)
     */
    private $sexo;

    /**
     * @var string $telefono
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @var string $celular
     *
     * @ORM\Column(name="celular", type="string", length=15, nullable=true)
     */
    private $celular;


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
     * Set nombre
     *
     * @param string $nombre
     * @return Solicitante
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Solicitante
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Solicitante
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     * @return Solicitante
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
    }

    /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     * @return Solicitante
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    
        return $this;
    }

    /**
     * Get cuit
     *
     * @return string 
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set cpf
     *
     * @param string $cpf
     * @return Solicitante
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    
        return $this;
    }

    /**
     * Get cpf
     *
     * @return string 
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Solicitante
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    
        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set sexo
     *
     * @param MiCiudad\ModeloBundle\Entity\Sexo $sexo
     * @return Solicitante
     */
    public function setSexo(\MiCiudad\ModeloBundle\Entity\Sexo $sexo = null)
    {
        $this->sexo = $sexo;
    
        return $this;
    }

    /**
     * Get sexo
     *
     * @return MiCiudad\ModeloBundle\Entity\Sexo 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Solicitante
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Solicitante
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    
        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }
}
