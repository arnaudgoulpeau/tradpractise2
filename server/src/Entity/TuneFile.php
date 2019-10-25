<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TuneFileRepository")
 * @Vich\Uploadable
 */
class TuneFile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tune", inversedBy="tuneFiles")
     * @ORM\JoinColumn(name="tune_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     */
    private $tune;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="tune_files", fileNameProperty="fileName")
     *
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TuneFileType")
     * @ORM\JoinColumn(name="tune_file_type_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     */
    private $tuneFileType;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mandolinTabId;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
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
        return $this->fileName;
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
     * @return TuneFile
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
     * Set tune
     *
     * @param \App\Entity\Tune $tune
     * @return TuneFile
     */
    public function setTune(\App\Entity\Tune $tune)
    {
        $this->tune = $tune;

        return $this;
    }

    /**
     * Get tune
     *
     * @return \App\Entity\Tune
     */
    public function getTune()
    {
        return $this->tune;
    }

    /**
     * Set tuneFileType
     *
     * @param \App\Entity\TuneFileType $tuneFileType
     * @return TuneFile
     */
    public function setTuneFileType(\App\Entity\TuneFileType $tuneFileType)
    {
        $this->tuneFileType = $tuneFileType;

        return $this;
    }

    /**
     * Get tuneFileType
     *
     * @return \App\Entity\TuneFileType
     */
    public function getTuneFileType()
    {
        return $this->tuneFileType;
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

    /**
     * Set mandolinTabId
     *
     * @param string $mandolinTabId
     * @return TuneFile
     */
    public function setMandolinTabId($mandolinTabId)
    {
        $this->mandolinTabId = $mandolinTabId;

        return $this;
    }

    /**
     * Get isImportedFromMandolinTab
     *
     * @return string
     */
    public function getMandolinTabId()
    {
        return $this->mandolinTabId;
    }
}
