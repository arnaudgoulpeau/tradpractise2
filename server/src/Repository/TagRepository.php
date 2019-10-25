<?php

namespace App\Repository;

use App\Entity\TuneFileType;
use Doctrine\ORM\EntityRepository;

/**
 * TagRepository
 */
class TagRepository extends EntityRepository
{
    /**
     * @param array $names
     * @return array
     */
    public function findByNameIn(array $names)
    {
        $qb = $this->createQueryBuilder('t');

        $qb->andWhere('t.name IN (:names)')
            ->setParameter('names', $names);

        return $qb
            ->orderBy('t.name', 'ASC')
            ->getQuery()->getResult();
    }
}
