<?php

namespace Marlene\ActasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actas
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Marlene\ActasBundle\Entity\ActasRepository")
 */
class Actas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   
    /**
     *@ORM\ManyToOne(targetEntity="Cliente", inversedBy="actas")
     */
    private $cliente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="abogado", type="object")
     */
    private $abogado;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="creador", type="object")
     */
    private $creador;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="text")
     */
    private $detalle;

    /**
    *@ORM\ManyToOne(targetEntity="Juzgado")
    */
    private $juzgado;


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
     * Set cliente
     *
     * @param \stdClass $cliente
     * @return Actas
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \stdClass 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     * @return Actas
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Actas
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

    /**
     * Set abogado
     *
     * @param \stdClass $abogado
     * @return Actas
     */
    public function setAbogado($abogado)
    {
        $this->abogado = $abogado;

        return $this;
    }

    /**
     * Get abogado
     *
     * @return \stdClass 
     */
    public function getAbogado()
    {
        return $this->abogado;
    }

    /**
     * Set creador
     *
     * @param \stdClass $creador
     * @return Actas
     */
    public function setCreador($creador)
    {
        $this->creador = $creador;

        return $this;
    }

    /**
     * Get creador
     *
     * @return \stdClass 
     */
    public function getCreador()
    {
        return $this->creador;
    }


    public function setJuzgado($juzgado)
    {
        $this->juzgado = $juzgado;

        return $this;
    }

    /**
     * Get juzgado
     *
     * @return \Juzgado 
     */
    public function getJuzgado()
    {
        return $this->juzgado;
    }
}
