<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ApiResource()
 * @ORM\Entity
 */
class TuneSet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tune", inversedBy="tuneSets1")
     * @ORM\JoinColumn(name="tune1_id", referencedColumnName="id", nullable=true)
     */
    private $tune1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tune", inversedBy="tuneSets2")
     * @ORM\JoinColumn(name="tune2_id", referencedColumnName="id", nullable=true)
     */
    private $tune2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tune", inversedBy="tuneSets3")
     * @ORM\JoinColumn(name="tune3_id", referencedColumnName="id", nullable=true)
     */
    private $tune3;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tune", inversedBy="tuneSets4")
     * @ORM\JoinColumn(name="tune4_id", referencedColumnName="id", nullable=true)
     */
    private $tune4;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tune", inversedBy="tuneSets5")
     * @ORM\JoinColumn(name="tune5_id", referencedColumnName="id", nullable=true)
     */
    private $tune5;

    /**
     * @ORM\ManyToMany(targetEntity="PractiseSession", mappedBy="tuneSets")
     */
    private $practiseSessions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->practiseSessions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * to string
     * @return string
     */
    public function __toString()
    {
        $concat = "";
        if ($this->tune1 !== null) {
            $concat .= $this->tune1->getName().($this->tune1->getIsStared() ? " <i class='fa fa-star'></i>" : "");
        }
        if ($this->tune2 !== null) {
            $concat .= " | ".$this->tune2->getName().($this->tune2->getIsStared() ? " <i class='fa fa-star'></i>" : "");
        }
        if ($this->tune3 !== null) {
            $concat .= " | ".$this->tune3->getName().($this->tune3->getIsStared() ? " <i class='fa fa-star'></i>" : "");
        }
        if ($this->tune4 !== null) {
            $concat .= " | ".$this->tune4->getName().($this->tune4->getIsStared() ? " <i class='fa fa-star'></i>" : "");
        }
        if ($this->tune5 !== null) {
            $concat .= " | ".$this->tune5->getName().($this->tune5->getIsStared() ? " <i class='fa fa-star'></i>" : "");
        }

        return $concat;
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
     * Set tune1
     *
     * @param \App\Entity\Tune $tune1
     * @return TuneSet
     */
    public function setTune1(\App\Entity\Tune $tune1 = null)
    {
        $this->tune1 = $tune1;

        return $this;
    }

    /**
     * Get tune1
     *
     * @return \App\Entity\Tune
     */
    public function getTune1()
    {
        return $this->tune1;
    }

    /**
     * Set tune2
     *
     * @param \App\Entity\Tune $tune2
     * @return TuneSet
     */
    public function setTune2(\App\Entity\Tune $tune2 = null)
    {
        $this->tune2 = $tune2;

        return $this;
    }

    /**
     * Get tune2
     *
     * @return \App\Entity\Tune
     */
    public function getTune2()
    {
        return $this->tune2;
    }

    /**
     * Set tune3
     *
     * @param \App\Entity\Tune $tune3
     * @return TuneSet
     */
    public function setTune3(\App\Entity\Tune $tune3 = null)
    {
        $this->tune3 = $tune3;

        return $this;
    }

    /**
     * Get tune3
     *
     * @return \App\Entity\Tune
     */
    public function getTune3()
    {
        return $this->tune3;
    }

    /**
     * Set tune4
     *
     * @param \App\Entity\Tune $tune4
     * @return TuneSet
     */
    public function setTune4(\App\Entity\Tune $tune4 = null)
    {
        $this->tune4 = $tune4;

        return $this;
    }

    /**
     * Get tune4
     *
     * @return \App\Entity\Tune
     */
    public function getTune4()
    {
        return $this->tune4;
    }

    /**
     * Set tune5
     *
     * @param \App\Entity\Tune $tune5
     * @return TuneSet
     */
    public function setTune5(\App\Entity\Tune $tune5 = null)
    {
        $this->tune5 = $tune5;

        return $this;
    }

    /**
     * Get tune5
     *
     * @return \App\Entity\Tune
     */
    public function getTune5()
    {
        return $this->tune5;
    }

    /**
     * Add practiseSessions
     *
     * @param \App\Entity\PractiseSession $practiseSessions
     * @return TuneSet
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
