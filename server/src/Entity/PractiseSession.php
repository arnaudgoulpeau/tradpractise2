<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PractiseSessionRepository")
 */
class PractiseSession
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="TuneSet", inversedBy="practiseSessions")
     *
     */
    private $tuneSets;

    /**
     * @ORM\ManyToMany(targetEntity="Technique", inversedBy="practiseSessions")
     */
    private $techniques;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tune")
     * @ORM\JoinColumn(name="warmup_tune_id", referencedColumnName="id", nullable=false)
     */
    private $warmupTune;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tuneSets = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return PractiseSession
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
     * Set notes
     *
     * @param string $notes
     * @return PractiseSession
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add tuneSets
     *
     * @param \App\Entity\TuneSet $tuneSets
     * @return PractiseSession
     */
    public function addTuneSet(\App\Entity\TuneSet $tuneSets)
    {
        $this->tuneSets[] = $tuneSets;

        return $this;
    }

    /**
     * Remove tuneSets
     *
     * @param \App\Entity\TuneSet $tuneSets
     */
    public function removeTuneSet(\App\Entity\TuneSet $tuneSets)
    {
        $this->tuneSets->removeElement($tuneSets);
    }

    /**
     * Get tuneSets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneSets()
    {
        return $this->tuneSets;
    }

    /**
     * Add techniques
     *
     * @param \App\Entity\Technique $techniques
     * @return PractiseSession
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
     * Set warmupTune
     *
     * @param \App\Entity\Tune $warmupTune
     * @return PractiseSession
     */
    public function setWarmupTune(\App\Entity\Tune $warmupTune)
    {
        $this->warmupTune = $warmupTune;

        return $this;
    }

    /**
     * Get warmupTune
     *
     * @return \App\Entity\Tune
     */
    public function getWarmupTune()
    {
        return $this->warmupTune;
    }

    public function __toString()
    {
        return $this->name;
    }
}
