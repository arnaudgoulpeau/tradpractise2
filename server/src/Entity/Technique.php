<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechniqueRepository")
 * @ApiResource()
 */
class Technique
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $exampleLink;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TechniqueFile", mappedBy="technique", cascade={"all"})
     */
    private $techniqueFiles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TechniqueType", inversedBy="techniques")
     * @ORM\JoinColumn(name="technique_type_id", referencedColumnName="id", nullable=false)
     */
    private $techniqueType;

    /**
     * @ORM\ManyToMany(targetEntity="PractiseSession", mappedBy="techniques")
     */
    private $practiseSessions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->techniqueFiles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->practiseSessions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     *
     * @return type
     */
    public function __toString()
    {
        return $this->name;
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
     * @return Technique
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
     * Set exampleLink
     *
     * @param string $exampleLink
     * @return Technique
     */
    public function setExampleLink($exampleLink)
    {
        $this->exampleLink = $exampleLink;

        return $this;
    }

    /**
     * Get exampleLink
     *
     * @return string
     */
    public function getExampleLink()
    {
        return $this->exampleLink;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Technique
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add techniqueFiles
     *
     * @param \App\Entity\TechniqueFile $techniqueFiles
     * @return Technique
     */
    public function addTechniqueFile(\App\Entity\TechniqueFile $techniqueFiles)
    {
        $this->techniqueFiles[] = $techniqueFiles;

        return $this;
    }

    /**
     * Remove techniqueFiles
     *
     * @param \App\Entity\TechniqueFile $techniqueFiles
     */
    public function removeTechniqueFile(\App\Entity\TechniqueFile $techniqueFiles)
    {
        $this->techniqueFiles->removeElement($techniqueFiles);
    }

    /**
     * Get techniqueFiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTechniqueFiles()
    {
        return $this->techniqueFiles;
    }

    /**
     * Set techniqueType
     *
     * @param \App\Entity\TechniqueType $techniqueType
     * @return Technique
     */
    public function setTechniqueType(\App\Entity\TechniqueType $techniqueType)
    {
        $this->techniqueType = $techniqueType;

        return $this;
    }

    /**
     * Get techniqueType
     *
     * @return \App\Entity\TechniqueType
     */
    public function getTechniqueType()
    {
        return $this->techniqueType;
    }

    /**
     * Add practiseSessions
     *
     * @param \App\Entity\PractiseSession $practiseSessions
     * @return Technique
     */
    public function addPractiseSession(\App\Entity\PractiseSession $practiseSessions)
    {
        $this->practiseSessions[] = $practiseSessions;

        return $this;
    }

    /**
     * Remove practiseSessions
     *
     * @param \App\Entity\PractiseSession $practiseSessions
     */
    public function removePractiseSession(\App\Entity\PractiseSession $practiseSessions)
    {
        $this->practiseSessions->removeElement($practiseSessions);
    }

    /**
     * Get practiseSessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPractiseSessions()
    {
        return $this->practiseSessions;
    }
}
