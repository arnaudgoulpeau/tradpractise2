<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping AS ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ApiResource()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class TechniqueFile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Technique", inversedBy="techniqueFiles")
     * @ORM\JoinColumn(name="technique_id", referencedColumnName="id", nullable=false)
     */
    private $technique;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TechniqueFileType")
     * @ORM\JoinColumn(name="technique_file_type_id", referencedColumnName="id", nullable=false)
     */
    private $techniqueFileType;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="tune_files", fileNameProperty="fileName")
     *
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $link;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\File $file = null)
    {
        $this->file = $file;

        if ($file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return TuneFile
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     *
     * @return type
     */
    public function __toString()
    {
        return $this->fileName ? $this->fileName : "";
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
     * Set name
     *
     * @param string $name
     * @return TechniqueFile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set technique
     *
     * @param \App\Entity\Technique $technique
     * @return TechniqueFile
     */
    public function setTechnique(\App\Entity\Technique $technique)
    {
        $this->technique = $technique;

        return $this;
    }

    /**
     * Get technique
     *
     * @return \App\Entity\Technique
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * Set techniqueFileType
     *
     * @param \App\Entity\TechniqueFileType $techniqueFileType
     * @return TechniqueFile
     */
    public function setTechniqueFileType(\App\Entity\TechniqueFileType $techniqueFileType)
    {
        $this->techniqueFileType = $techniqueFileType;

        return $this;
    }

    /**
     * Get techniqueFileType
     *
     * @return \App\Entity\TechniqueFileType
     */
    public function getTechniqueFileType()
    {
        return $this->techniqueFileType;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return TuneFile
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
}
