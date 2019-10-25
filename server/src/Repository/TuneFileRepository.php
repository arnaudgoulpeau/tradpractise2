<?php

namespace App\Repository;

use App\Entity\TuneFileType;
use Doctrine\ORM\EntityRepository;

/**
 * TuneFileRepository
 */
class TuneFileRepository extends EntityRepository
{
    /**
     * @param bool $includeSlow
     * @return array
     */
    public function getAllMp3(string $searchTerm = null, string $selectedTag = null, string $selectedType = null, string $stared = null, bool $includeSlow = true)
    {
        $qb = $this->createQueryBuilder('tf');
        $qb
            ->innerJoin('tf.tune', 't')
            ->innerJoin("t.tags", 'tag');

        if ($searchTerm) {
            $qb->andWhere('tf.name LIKE :term')
                ->setParameter('term', "%".$searchTerm."%");
        }

        if ($selectedTag) {
            $qb->andWhere("tag.id LIKE :tagId")
                ->setParameter('tagId', $selectedTag);
        }
        if ($selectedType) {
            $qb->innerJoin("t.tuneType", 'type')
                ->andWhere("type.id LIKE :typeId")
                ->setParameter('typeId', $selectedType);
        }
        if ($stared !== null && $stared !== "") {
            $qb
                ->andWhere("t.isStared = :stared")
                ->setParameter('stared', $stared);
        }

        $qb->andWhere('tf.tuneFileType = :mp3')
            ->setParameter('mp3', TuneFileType::TUNE_FILE_TYPE_MP3_ID);

        return $qb
                ->orderBy('tf.name', 'ASC')
                ->getQuery()->getResult();

    }
}
