<?php

namespace SoundShare\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_news")
 * @ORM\Entity(repositoryClass="SoundShare\AdminBundle\Entity\SiteNewsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class SiteNews
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $soundPath;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $imagePath;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $content;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
        //return $this;
    }
    
    public function getCreatedAt() {
        return $this->createdAt;
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
     * Set title
     *
     * @param string $title
     * @return SiteNews
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set soundPath
     *
     * @param string $soundPath
     * @return SiteNews
     */
    public function setSoundPath($soundPath)
    {
        $this->soundPath = $soundPath;

        return $this;
    }

    /**
     * Get soundPath
     *
     * @return string 
     */
    public function getSoundPath()
    {
        return $this->soundPath;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     * @return SiteNews
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string 
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return SiteNews
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return SiteNews
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SiteNews
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
