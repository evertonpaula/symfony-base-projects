<?php

namespace Epsoftware\UserBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload 
 * @ORM\HasLifecycleCallbacks
*/
abstract class UploadImage
{
    private $temp;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @Assert\File(
     *          maxSize = "2M", 
     *          maxSizeMessage="O arquivo é muito grande ({{ size }} {{ suffix }}). O tamnaho máximo é {{ limit }} {{ suffix }}.", 
     *          mimeTypes = {"image/pjpeg","image/jpeg","image/png"}, 
     *          mimeTypesMessage = "É somente aceita extensão de imagem jpg, jpeg ou png.", 
     *          disallowEmptyMessage = "Obrigatório selecionar um arquivo.", 
     *          notFoundMessage = "Arquivo não encontrado.",
     *          uploadIniSizeErrorMessage = "O arquivo é muito grande. Máximo permitido de {{ limit }} {{ suffix }}.", 
     *          uploadFormSizeErrorMessage = "Arquivo muito grande.", 
     *          groups={"upload"}
     *      )
     */
    private $file;
    
    /**
     * Get file.
     *
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Sets file.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'default.png';
        }
    }
    
    /**
     * Get path
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()){
            // do whatever you want to generate a unique name
            $filename = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp) && $this->temp !== null && !empty($this->temp) && $this->temp !== "default.png") {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file && $this->temp !== "default.png") {
            unlink($file);
        }
    }
        
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../public_html/'.$this->getUploadDir();
    }

    public abstract function getUploadDir();
}