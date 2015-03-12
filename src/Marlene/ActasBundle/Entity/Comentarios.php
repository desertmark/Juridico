<?php

namespace Marlene\ActasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\UserBundle\Entity\User;

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
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * @param \DateTime $fechaHora
     * @return Comentarios
     */
    public function setFechaHora($fechaHora)
    {
        $this->fechaHora = $fechaHora;

        return $this;
    }

    /**
     * Get fechaHora
     *
     * @return \DateTime 
     */
    public function getFechaHora()
    {
        return $this->fechaHora;
    }

    /**
     * Set creador
     *
     * @param \Acme\UserBundle\Entity\User $creador
     * @return Comentarios
     */
    public function setCreador(\Acme\UserBundle\Entity\User $creador = null)
    {
        $this->creador = $creador;

        return $this;
    }

    /**
     * Get creador
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getCreador()
    {
        return $this->creador;
    }
}
