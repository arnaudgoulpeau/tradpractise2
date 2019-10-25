<?php
namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ApiResource()
 * @ORM\Entity
 */
class TuneType
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
     * @ORM\OneToMany(targetEntity="App\Entity\Tune", mappedBy="tuneType")
     */
    private $tunes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tunes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return TuneType
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
     * Add tune
     *
     * @param \App\Entity\Tune $tune
     * @return TuneType
     */
    public function addTune(\App\Entity\Tune $tune)
    {
        $this->tunes[] = $tune;

        return $this;
    }

    /**
     * Remove tune
     *
     * @param \App\Entity\Tune $tune
     */
    public function removeTune(\App\Entity\Tune $tune)
    {
        $this->tunes->removeElement($tune);
    }

    /**
     * Get tune
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTunes()
    {
        return $this->tunes;
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
