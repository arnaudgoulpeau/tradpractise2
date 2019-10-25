<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TechniqueRepository
 */
class TechniqueRepository extends EntityRepository
{
    /**
     *
     * @param type $term
     * @param type $typeId
     * @return type
     */
    public function search($term, $typeId)
    {
        $qb = $this->createQueryBuilder('t');

        if ($term) {
            $qb->andWhere("t.name LIKE :term")
                ->setParameter('term', "%".$term."%");
        }
        if ($typeId) {
            $qb->innerJoin("t.techniqueType", 'type')
                ->andWhere("type.id LIKE :typeId")
                ->setParameter('typeId', $typeId);
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
