<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ApiResource()
 */
class TechniqueType
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
     * @ORM\OneToMany(targetEntity="App\Entity\Technique", mappedBy="techniqueType")
     */
    private $techniques;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->techniques = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return TechniqueType
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
     * Add techniques
     *
     * @param \App\Entity\Technique $techniques
     * @return TechniqueType
     */
    public function addTechnique(\App\Entity\Technique $techniques)
    {
        $this->techniques[] = $techniques;

        return $this;
    }

    /**
     * Remove techniques
     *
     * @param \App\Entity\Technique $techniques
     */
    public function removeTechnique(\App\Entity\Technique $techniques)
    {
        $this->techniques->removeElement($techniques);
    }

    /**
     * Get techniques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     *
     * @return type
     */
    public function __toString()
    {
        return $this->name;
    }
}
