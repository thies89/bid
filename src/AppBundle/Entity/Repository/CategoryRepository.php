<?php

namespace Strassen\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('weight' => 'ASC'));
    }
}
