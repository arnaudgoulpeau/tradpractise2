<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PractiseSessionRepository
 */
class PractiseSessionRepository extends EntityRepository
{
    /**
     *
     * @param type $term
     * @return type
     */
    public function search($term, $tagId)
    {
        $qb = $this->createQueryBuilder('ps');
        if ($term || $tagId) {
            $qb->join('ps.tuneSets', 'ts')
            ->leftJoin("ts.tune1", 't1')
            ->leftJoin("ts.tune2", 't2')
            ->leftJoin("ts.tune3", 't3')
            ->leftJoin("ts.tune4", 't4')
            ->leftJoin("ts.tune5", 't5')
            ;
        }
        if ($term) {
            $qb->where("t1.name LIKE :term OR t2.name LIKE :term OR t3.name LIKE :term OR t4.name LIKE :term OR t5.name LIKE :term")
            ->setParameter('term', "%".$term."%");
        }
        if ($tagId) {
            $qb
            ->leftJoin("t1.tags", 'tag1')
            ->leftJoin("t2.tags", 'tag2')
            ->leftJoin("t3.tags", 'tag3')
            ->leftJoin("t4.tags", 'tag4')
            ->leftJoin("t5.tags", 'tag5')
            ->orWhere("tag1.id = :tag OR tag2.id = :tag OR tag3.id = :tag OR tag4.id = :tag OR tag5.id = :tag")
            ->setParameter('tag', $tagId)
            ;
        }

        return $qb
                ->orderBy('ps.id', 'DESC')
                ->getQuery()->getResult();

    }
}
