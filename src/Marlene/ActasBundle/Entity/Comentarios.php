<?php

namespace Marlene\ActasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentarios
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Marlene\ActasBundle\Entity\ComentariosRepository")
 */
class Comentarios
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
     * @var \Abogado
     *
     * @ORM\ManyToOne(targetEntity="Abogado")
     */
    private $creador;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text")
     */
    private $texto;

    /**
     *@var \DateTime
     *
     *@ORM\Column(name="fecha_hora", type="datetime")
     */
    private $fechaHora;

    /**
     * @var \Actas
     *
     * @ORM\ManyToOne(targetEntity="Actas", inversedBy="comentarios")
     */
    private $acta;


    /*METODOS*/


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
     * Set creador
     *
     * @param string $creador
     * @return Comentarios
     */
    public function setCreador($creador)
    {
        $this->creador = $creador;

        return $this;
    }

    /**
     * Get creador
     *
     * @return string 
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Comentarios
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set fechaHora
     *
     * @param string $fechaHora
     * @return \DateTime
     */
    public function setFechaHora($fechaHora)
    {
        $this->fechaHora = $fechaHora;

        return $this;
    }

    /**
     * Get Fecha Hora
     *
     * @return \DateTime 
     */
    public function getFechaHora()
    {
        return $this->fechaHora;
    }

    /**
     * Set Acta
     *
     * @param Acta $acta
     * @return \Acta
     */
    public function setActa($acta)
    {
        $this->acta = $acta;

        return $this;
    }

    /**
     * Get Acta
     *
     * @return \Acta 
     */
    public function getActa()
    {
        return $this->acta;
    }
}
