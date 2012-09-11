<?php

namespace MiCiudad\ModeloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiCiudad\ModeloBundle\Entity\DatoExtendido
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MiCiudad\ModeloBundle\Entity\DatoExtendidoRepository")
 */
class DatoExtendido
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
     * @var MiCiudad\ModeloBundle\Entity\Solicitud $solicitud
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\Solicitud", inversedBy="datosExtendidos")
     */
    private $solicitud;

    /**
     * @var MiCiudad\ModeloBundle\Entity\CampoExtendido $campoExtendido
     *
     * @ORM\ManyToOne(targetEntity="MiCiudad\ModeloBundle\Entity\CampoExtendido")
     */
    private $campoExtendido;

    /**
     * @var string $valor
     *
     * @ORM\Column(name="valor", type="text")
     */
    private $valor;


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
     * @param MiCiudad\ModeloBundle\Entity\Solicitud $solicitud
     * @return DatoExtendido
     */
    public function setSolicitud(\MiCiudad\ModeloBundle\Entity\Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
    
        return $this;
    }

    /**
     * Get solicitud
     *
     * @return MiCiudad\ModeloBundle\Entity\Solicitud 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set campoExtendido
     *
     * @param MiCiudad\ModeloBundle\Entity\CampoExtendido $campoExtendido
     * @return DatoExtendido
     */
    public function setCampoExtendido(\MiCiudad\ModeloBundle\Entity\CampoExtendido $campoExtendido)
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
     * Set valor
     *
     * @param string $valor
     * @return DatoExtendido
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }
}
