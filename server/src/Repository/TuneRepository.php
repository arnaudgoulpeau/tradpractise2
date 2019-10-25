<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TuneRepository
 */
class TuneRepository extends EntityRepository
{
    /**
     *
     * @param type $term
     * @param type $tagId
     * @param type $typeId
     * @param type $stared
     * @return type
     */
    public function search($term, $tagId, $typeId, $stared)
    {
        $qb = $this->createQueryBuilder('t');

        if ($term) {
            $qb->andWhere("t.name LIKE :term")
                ->setParameter('term', "%".$term."%");
        }
        if ($tagId) {
            $qb->innerJoin("t.tags", 'tag')
                ->andWhere("tag.id LIKE :tagId")
                ->setParameter('tagId', $tagId);
        }
        if ($typeId) {
            $qb->innerJoin("t.tuneType", 'type')
                ->andWhere("type.id LIKE :typeId")
                ->setParameter('typeId', $typeId);
        }
        if ($stared !== null && $stared !== "") {
            $qb
                ->andWhere("t.isStared = :stared")
                ->setParameter('stared', $stared);
        }

        return $qb
                ->orderBy('t.name', 'ASC')
                ->getQuery()->getResult();

    }

    /**
     *
     * @return type
     */
    public function findForIssues()
    {
        $qb = $this->createQueryBuilder('t');

        $qb->leftJoin("t.tuneSets1", 'ts1');
        $qb->leftJoin("t.tuneSets2", 'ts2');
        $qb->leftJoin("t.tuneSets3", 'ts3');
        $qb->leftJoin("t.tuneSets4", 'ts4');
        $qb->leftJoin("t.tuneSets5", 'ts5');

        $qb->leftJoin("t.tuneFiles", 'tf');
        $qb->leftJoin("tf.tuneFileType", 'tft');

        return $qb
                ->orderBy('t.name', 'ASC')
                ->getQuery()->getResult();
    }
}
