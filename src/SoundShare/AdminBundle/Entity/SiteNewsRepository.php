<?php


namespace SoundShare\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SiteNewsRepository extends EntityRepository {
    
    public function getLastNews() {
        $result = $this->getEntityManager()
          ->createQuery('SELECT n FROM SoundShareAdminBundle:siteNews n order by n.createdAt DESC')
          ->getResult();  
        
        return $result;
        
    }    
    
}

