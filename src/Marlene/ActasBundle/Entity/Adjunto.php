<?php

namespace Marlene\ActasBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adjunto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Marlene\ActasBundle\Entity\AdjuntoRepository")
 */
class Adjunto
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;


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
     * @return Adjunto
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
     * Set extension
     *
     * @param string $extension
     * @return Adjunto
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Adjunto
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     * @Assert\File(mimeTypes={"application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel",
     *
     *  "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.oasis.opendocument.spreadsheet",
     *
     *  "application/vnd.oasis.opendocument.text", "image/png", "image/jpeg", "application/vnd.oasis.opendocument.text-template"},
     * mimeTypesMessage = "Los tipos de documentos soportados son: .docx, .xlsx, .pdf, .png, .jpeg")
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getAdjuntoDir()
    {
        return 'adjuntos';
    }

    public function getServerDir()
    {
        return __DIR__.'/../../../../web/'.$this->getAdjuntoDir();
    }
    public function guardarAdjunto(UploadedFile $file)
    {
        try 
        {
            //objeto para encontrar archivos.
            $fs = new Filesystem();
            $extension = $file->guessExtension();
            if (!$extension) {
                $extension = 'bin';
            }            
            $this->setExtension($extension);
            $this->setPath($this->getAdjuntoDir().'/'.$this->getNombre().'.'.$extension);

            if ( $file->isValid() and !$fs->exists($this->getPath()) ) {
    
                $file->move($this->getServerDir(), $this->getNombre().'.'.$extension);//tambien anda con getAdjuntoDir()
                return 'ok';   
            } else {
                return 'Error: el archivo no pude subirse correctamente. Compruebe que no exista uno con el mismo nombre.';
            }
           
        } 
        catch (Exception $e) 
        {
            return 'Error: '.$e->getMessage();     
        }
    }
    public function borrarAdjunto()
    {
        $fs = new Filesystem();
        try {
            $fs->remove($this->getPath());
        } catch (IOExceptionInterface $e) {

        }
    }
}
