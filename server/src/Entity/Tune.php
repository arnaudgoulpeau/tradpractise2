<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TuneRepository")
 * @ApiResource()
 */
class Tune
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $abc;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TuneFile", mappedBy="tune", cascade={"all"})
     */
    private $tuneFiles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TuneType", inversedBy="tunes")
     * @ORM\JoinColumn(name="tune_type_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     */
    private $tuneType;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $linkTheSession;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isStared = false;

    /**
     * @ORM\Column(type="string", nullable=true, name="music_key")
     */
    private $key;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TuneSet", mappedBy="tune1")
     */
    private $tuneSets1;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TuneSet", mappedBy="tune2")
     */
    private $tuneSets2;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TuneSet", mappedBy="tune3")
     */
    private $tuneSets3;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TuneSet", mappedBy="tune4")
     */
    private $tuneSets4;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TuneSet", mappedBy="tune5")
     */
    private $tuneSets5;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag")
     * @ORM\JoinTable(name="tune_tag",
     *      joinColumns={@ORM\JoinColumn(name="tune_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="cascade")}
     * )
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tuneFiles = new \Doctrine\Common\Collections\ArrayCollection();

        $this->tuneSets1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tuneSets2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tuneSets3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tuneSets4 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tuneSets5 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     *
     * @return string
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
     * @return Tune
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
     * Set abc
     *
     * @param string $abc
     * @return Tune
     */
    public function setAbc($abc)
    {
        $this->abc = $abc;

        return $this;
    }

    /**
     * Get abc
     *
     * @return string
     */
    public function getAbc()
    {
        return $this->abc;
    }

    /**
     * Set linkTheSession
     *
     * @param string $linkTheSession
     * @return Tune
     */
    public function setLinkTheSession($linkTheSession)
    {
        $this->linkTheSession = $linkTheSession;

        return $this;
    }

    /**
     * Get linkTheSession
     *
     * @return string
     */
    public function getLinkTheSession()
    {
        return $this->linkTheSession;
    }

    /**
     * Set isStared
     *
     * @param boolean $isStared
     * @return Tune
     */
    public function setIsStared($isStared)
    {
        $this->isStared = $isStared;

        return $this;
    }

    /**
     * Get isStared
     *
     * @return boolean
     */
    public function getIsStared()
    {
        return $this->isStared;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return Tune
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Add tuneFiles
     *
     * @param \App\Entity\TuneFile $tuneFile
     * @return Tune
     */
    public function addTuneFile(\App\Entity\TuneFile $tuneFile)
    {
        $tuneFile->setTune($this);
        $this->tuneFiles[] = $tuneFile;

        return $this;
    }

    /**
     * Remove tuneFiles
     *
     * @param \App\Entity\TuneFile $tuneFiles
     */
    public function removeTuneFile(\App\Entity\TuneFile $tuneFiles)
    {
        $this->tuneFiles->removeElement($tuneFiles);
    }

    /**
     * Get tuneFiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneFiles()
    {
        return $this->tuneFiles;
    }

    /**
     * Set tuneType
     *
     * @param \App\Entity\TuneType $tuneType
     * @return Tune
     */
    public function setTuneType(\App\Entity\TuneType $tuneType)
    {
        $this->tuneType = $tuneType;

        return $this;
    }

    /**
     * Get tuneType
     *
     * @return \App\Entity\TuneType
     */
    public function getTuneType()
    {
        return $this->tuneType;
    }

    /**
     * Add tags
     *
     * @param \App\Entity\Tag $tag
     * @return Tune
     */
    public function addTag(\App\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @param array $tags
     * @return Tune
     */
    public function addTags(array $tags)
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \App\Entity\Tag $tag
     */
    public function removeTag(\App\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get tuneSets1
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneSets1()
    {
        return $this->tuneSets1;
    }

    /**
     * Get tuneSets2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneSets2()
    {
        return $this->tuneSets2;
    }

    /**
     * Get tuneSets3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneSets3()
    {
        return $this->tuneSets3;
    }

    /**
     * Get tuneSets4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneSets4()
    {
        return $this->tuneSets4;
    }

    /**
     * Get tuneSets5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneSets5()
    {
        return $this->tuneSets5;
    }

    /**
     *
     * @return boolean
     */
    public function hasTuneSet()
    {
        $hasTuneSet = false;
        if ($this->getTuneSets1()->count() > 0
            || $this->getTuneSets2()->count() > 0
            || $this->getTuneSets3()->count() > 0
            || $this->getTuneSets4()->count() > 0
            || $this->getTuneSets5()->count() > 0) {
            $hasTuneSet = true;
        }

        return $hasTuneSet;
    }

    /**
     *
     * @return boolean
     */
    public function hasPartition()
    {
        $hasPartition = false;
        foreach ($this->getTuneFiles() as $tuneFile) {
            if ($tuneFile->getTuneFileType()->getId() === TuneFileType::TUNE_FILE_TYPE_PARTITION_ID) {
                $hasPartition = true;
            }
        }

        return $hasPartition;
    }

    /**
     *
     * @return type
     */
    public function hasAbc()
    {
        return $this->getAbc() != null;
    }
}
