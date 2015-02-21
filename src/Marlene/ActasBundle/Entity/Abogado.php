<?php

namespace Marlene\ActasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abogado
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Marlene\ActasBundle\Entity\AbogadoRepository")
 */
class Abogado
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
     * @var string
     *
     * @ORM\Column(name="CUIT", type="bigint")
     */
    private $cUIT;

    /**
     * @var string
     *
     * @ORM\Column(name="Apellido", type="string", length=255)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="Telefono", type="bigint")
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;


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
     * Set cUIT
     *
     * @param string $cUIT
     * @return Abogado
     */
    public function setCUIT($cUIT)
    {
        $this->cUIT = $cUIT;

        return $this;
    }

    /**
     * Get cUIT
     *
     * @return string 
     */
    public function getCUIT()
    {
        return $this->cUIT;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Abogado
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
     * Set nombre
     *
     * @param string $nombre
     * @return Abogado
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
     * Set telefono
     *
     * @param integer $telefono
     * @return Abogado
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Abogado
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
     *
     */

    public function __toString()
    {
        return ''.$this->nombre.' '.$this->apellido.'('.$this->cUIT.')';
    }
}
