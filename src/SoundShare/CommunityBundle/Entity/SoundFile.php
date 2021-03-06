<?php

namespace SoundShare\CommunityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * SoundFile
 *
 * @ORM\Table(name="soundfile") 
 * @ORM\Entity(repositoryClass="SoundShare\CommunityBundle\Entity\SoundFileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SoundFile
{
    private $temp;
    
    private $file;
    
    public function getWebPath()
    {
        return null === $this->path ? null : '/sound/read/' . $this->id . '.' . $this->path;
    }

    private function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../app/Resources/sounds/';
    }    
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . $this->id . '.' . $this->path;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        // check if we have an old image
        if (isset($this->temp)) {
        // delete the old image
            unlink($this->temp);
        // clear the temp image path
            $this->temp = null;
        }
        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->id . '.' . $this->getFile()->guessExtension()
        );
        $this->setFile(null);
    }

    public function isFileTypeAllowed()
    {
        if (!file_exists($this->getFile())) {
            /** validation chain as failed before this test, file 'll be null */
            return true;
        }
        if (in_array($this->getFile()->getMimeType(), array(
                    'audio/mpeg',
                    'audio/x-wav',
                    'audio/x-flac',
                ))) {
            return true;
        }

        return false;
    }


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (is_file($this->getAbsolutePath())) {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $this->path = $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="MusicStyles", inversedBy="soundFiles")
     * @ORM\JoinColumn(name="style_id", referencedColumnName="id")
     * */
    private $style;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="soundFiles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="smallint", name="is_public")
     * @Assert\NotNull
     */
    private $isPublic;
    
    /**
     * @ORM\Column(type="datetime")
     * 
    */
    private $addedOn;
    
    /**
     * @ORM\PrePersist
     */
    public function setAddedOnValue() {
        $this->addedOn = new \DateTime();
        
        return $this;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
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
     * @return SoundFile
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
     * Set style
     *
     * @param \SoundShare\CommunityBundle\Entity\MusicStyles $style
     * @return SoundFile
     */
    public function setStyle(\SoundShare\CommunityBundle\Entity\MusicStyles $style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return \SoundShare\CommunityBundle\Entity\MusicStyles 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return SoundFile
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set isPublic
     *
     * @param integer $isPublic
     * @return SoundFile
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return integer 
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }


    /**
     * Set user
     *
     * @param \SoundShare\CommunityBundle\Entity\User $user
     * @return SoundFile
     */
    public function setUser(\SoundShare\CommunityBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SoundShare\CommunityBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set addedOn
     *
     * @param \DateTime $addedOn
     * @return SoundFile
     */
    public function setAddedOn($addedOn)
    {
        $this->addedOn = $addedOn;

        return $this;
    }

    /**
     * Get addedOn
     *
     * @return \DateTime 
     */
    public function getAddedOn()
    {
        return $this->addedOn;
    }
}
