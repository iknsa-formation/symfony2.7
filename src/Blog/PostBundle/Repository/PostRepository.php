<?php

namespace Blog\PostBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findLastThree()
    {
        return $this->getEntityManager()
                        ->createQuery(
                            'SELECT p.id, p.title, p.extension, p.summary, u.email FROM BlogPostBundle:Post p JOIN p.user u ORDER BY p.id DESC'
                        )
                        ->setMaxResults(3)
                        ->getResult();
    }
}
