<?php

namespace SoundShare\CommunityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use SoundShare\CommunityBundle\Entity\MusicStyles;
use Symfony\Component\Intl\Intl;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    const IS_ADMIN = 0;    

    public function __construct()
    {
        $this->musicStyles = new ArrayCollection();
        $this->soundFiles = new ArrayCollection();
        
        $this->friendsWithMe = new ArrayCollection();
        $this->myFriends = new ArrayCollection();
    }
 
    public function getCountryName() {
        return Intl::getRegionBundle()->getCountryName($this->getCountry());
    }
    
    public function __toString() {
        return $this->getLogin();
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $login;

    /**
     * @ORM\Column(type="string", length=4000)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="MusicStyles")
     * @ORM\JoinTable(name="user_musicstyles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="musicstyles_id", referencedColumnName="id")}
     *      )
     * */
    private $musicStyles;
    
    /**
     * @ORM\OneToMany(targetEntity="SoundFile", mappedBy="user") 
    */
    private $soundFiles;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=2500)
     */
    private $presentation;
    
    /**
     *
     * @ORM\Column(type="smallint", name="is_amdin")
     */
    private $isAdmin = self::IS_ADMIN;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="myFriends")
    **/
    private $friendsWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *      )
    **/
    private $myFriends;
    
    
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
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    
    
    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get Username, return the login
     * @return string
     */
    public function getUsername()
    {
        return $this->getLogin();
    }

    public function getRoles()
    {
        if ($this->isAdmin === 1) {
            return ['ROLE_ADMIN'];
        }
        
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return md5('3FrdR5g--YTGFFEED56790~~~~!!///;;%');
    }

    public function eraseCredentials()
    {        
    }

    /**
     * Set country
     *
     * @param string $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * Set presentation
     *
     * @param string $presentation
     * @return User
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string 
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Add musicStyles
     *
     * @param \SoundShare\CommunityBundle\Entity\MusicStyles $musicStyles
     * @return User
     */
    public function addMusicStyle(\SoundShare\CommunityBundle\Entity\MusicStyles $musicStyles)
    {
        $this->musicStyles[] = $musicStyles;

        return $this;
    }

    /**
     * Remove musicStyles
     *
     * @param \SoundShare\CommunityBundle\Entity\MusicStyles $musicStyles
     */
    public function removeMusicStyle(\SoundShare\CommunityBundle\Entity\MusicStyles $musicStyles)
    {
        $this->musicStyles->removeElement($musicStyles);
    }

    /**
     * Get musicStyles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMusicStyles()
    {
        return $this->musicStyles;
    }


    /**
     * Set isAdmin
     *
     * @param integer $isAdmin
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return integer 
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Add soundFiles
     *
     * @param \SoundShare\CommunityBundle\Entity\SoundFile $soundFiles
     * @return User
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

    /**
     * Add friendsWithMe
     *
     * @param \SoundShare\CommunityBundle\Entity\User $friendsWithMe
     * @return User
     */
    public function addFriendsWithMe(\SoundShare\CommunityBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe
     *
     * @param \SoundShare\CommunityBundle\Entity\User $friendsWithMe
     */
    public function removeFriendsWithMe(\SoundShare\CommunityBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add myFriends
     *
     * @param \SoundShare\CommunityBundle\Entity\User $myFriends
     * @return User
     */
    public function addMyFriend(\SoundShare\CommunityBundle\Entity\User $myFriends)
    {
        $this->myFriends[] = $myFriends;

        return $this;
    }

    /**
     * Remove myFriends
     *
     * @param \SoundShare\CommunityBundle\Entity\User $myFriends
     */
    public function removeMyFriend(\SoundShare\CommunityBundle\Entity\User $myFriends)
    {
        $this->myFriends->removeElement($myFriends);
    }

    /**
     * Get myFriends
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }
}
