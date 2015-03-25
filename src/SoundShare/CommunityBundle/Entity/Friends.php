<?php


namespace SoundShare\CommunityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="friends")
 * 
 */
class Friends {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="friend_user_id")
     */
    private $friendId;    
}

