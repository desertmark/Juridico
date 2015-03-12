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
     * @var \Abogado
     *
     * @ORM\ManyToOne(targetEntity="Abogado")
     */
    private $abogado;

    /**
     * @var \Abogado
     *
     * @ORM\ManyToOne(targetEntity="Abogado")
     *
     */
    private $abogadoContraparte;

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
     * @ORM\ManyToMany(targetEntity="Comentarios")
     * @ORM\JoinTable(name="actas_comentarios",
     *      joinColumns={@ORM\JoinColumn(name="acta_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comentario_id", referencedColumnName="id", unique=true)}
     *      )
     *@ORM\OrderBy({"fechaHora" = "desc"})
     **/
    private $comentarios;

     /**
     * @ORM\ManyToMany(targetEntity="Adjunto")
     * @ORM\JoinTable(name="actas_adjuntos",
     *      joinColumns={@ORM\JoinColumn(name="acta_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="adjunto_id", referencedColumnName="id", unique=true)}
     *      )
     *@ORM\OrderBy({"nombre" = "asc"})
     **/
    private $adjuntos;

    /**
     * @var string
     *
     * @ORM\Column(name="actuacion", type="text")
     */
    private $actuacion;

    /**
     *
     *@var string
     *@ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     *
     *@var string
     *@ORM\Column(name="auto", type="string")
     */
    private $auto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adjuntos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add comentarios
     *
     * @param \Marlene\ActasBundle\Entity\Comentarios $comentarios
     * @return Actas
     */
    public function addComentario(\Marlene\ActasBundle\Entity\Comentarios $comentarios)
    {
        $this->comentarios[] = $comentarios;

        return $this;
    }

    /**
     * Remove comentarios
     *
     * @param \Marlene\ActasBundle\Entity\Comentarios $comentarios
     */
    public function removeComentario(\Marlene\ActasBundle\Entity\Comentarios $comentarios)
    {
        $this->comentarios->removeElement($comentarios);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set cliente
     *
     * @param \Marlene\ActasBundle\Entity\Cliente $cliente
     * @return Actas
     */
    public function setCliente(\Marlene\ActasBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Marlene\ActasBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set abogado
     *
     * @param \Marlene\ActasBundle\Entity\Abogado $abogado
     * @return Actas
     */
    public function setAbogado(\Marlene\ActasBundle\Entity\Abogado $abogado = null)
    {
        $this->abogado = $abogado;

        return $this;
    }

    /**
     * Get abogado
     *
     * @return \Marlene\ActasBundle\Entity\Abogado 
     */
    public function getAbogado()
    {
        return $this->abogado;
    }

    /**
     * Set abogadoContraparte
     *
     * @param \Marlene\ActasBundle\Entity\Abogado $abogadoContraparte
     * @return Actas
     */
    public function setAbogadoContraparte(\Marlene\ActasBundle\Entity\Abogado $abogadoContraparte = null)
    {
        $this->abogadoContraparte = $abogadoContraparte;

        return $this;
    }

    /**
     * Get abogadoContraparte
     *
     * @return \Marlene\ActasBundle\Entity\Abogado 
     */
    public function getAbogadoContraparte()
    {
        return $this->abogadoContraparte;
    }

    /**
     * Set juzgado
     *
     * @param \Marlene\ActasBundle\Entity\Juzgado $juzgado
     * @return Actas
     */
    public function setJuzgado(\Marlene\ActasBundle\Entity\Juzgado $juzgado = null)
    {
        $this->juzgado = $juzgado;

        return $this;
    }

    /**
     * Get juzgado
     *
     * @return \Marlene\ActasBundle\Entity\Juzgado 
     */
    public function getJuzgado()
    {
        return $this->juzgado;
    }

    /**
     * Set actuacion
     *
     * @param string $actuacion
     * @return Actas
     */
    public function setActuacion($actuacion)
    {
        $this->actuacion = $actuacion;

        return $this;
    }

    /**
     * Get actuacion
     *
     * @return string 
     */
    public function getActuacion()
    {
        return $this->actuacion;
    }


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Actas
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
     * Set auto
     *
     * @param string $auto
     * @return Actas
     */
    public function setAuto($auto)
    {
        $this->auto = $auto;

        return $this;
    }

    /**
     * Get auto
     *
     * @return string 
     */
    public function getAuto()
    {
        return $this->auto;
    }

    /**
     * Add adjuntos
     *
     * @param \Marlene\ActasBundle\Entity\Adjunto $adjuntos
     * @return Actas
     */
    public function addAdjunto(\Marlene\ActasBundle\Entity\Adjunto $adjuntos)
    {
        $this->adjuntos[] = $adjuntos;

        return $this;
    }

    /**
     * Remove adjuntos
     *
     * @param \Marlene\ActasBundle\Entity\Adjunto $adjuntos
     */
    public function removeAdjunto(\Marlene\ActasBundle\Entity\Adjunto $adjuntos)
    {
        $this->adjuntos->removeElement($adjuntos);
    }

    /**
     * Get adjuntos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdjuntos()
    {
        return $this->adjuntos;
    }
}
