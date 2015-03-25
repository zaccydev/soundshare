<?php

namespace SoundShare\CommunityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\EntityRepository;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SoundShare\CommunityBundle\Entity\MusicStylesRepository")
 * @ORM\Table(name="musicstyles")
 * 
 */
class MusicStyles
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->soundFiles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $style;
    
    /**
     * @ORM\OneToMany(targetEntity="SoundFile", mappedBy="style") 
     */
    private $soundFiles;

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
     * Set style
     *
     * @param string $style
     * @return MusicStyles
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }
    
    // ???
    public function __toString() {
        return $this->style;
    }


    /**
     * Add soundFiles
     *
     * @param \SoundShare\CommunityBundle\Entity\SoundFile $soundFiles
     * @return MusicStyles
     */
    public function addSoundFile(\SoundShare\CommunityBundle\Entity\SoundFile $soundFiles)
    {
        $this->soundFiles[] = $soundFiles;

        return $this;
    }

    /**
     * Remove soundFiles
     *
     * @param \SoundShare\CommunityBundle\Entity\SoundFile $soundFiles
     */
    public function removeSoundFile(\SoundShare\CommunityBundle\Entity\SoundFile $soundFiles)
    {
        $this->soundFiles->removeElement($soundFiles);
    }

    /**
     * Get soundFiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSoundFiles()
    {
        return $this->soundFiles;
    }
}
