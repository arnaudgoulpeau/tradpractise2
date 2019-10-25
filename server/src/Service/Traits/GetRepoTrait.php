<?php

namespace App\Service\Traits;


trait GetRepoTrait
{
    /**
     * Returns entity repository
     * @param string $entityName
     * @param string $bundlename
     * @return EntityRepository
     */
    protected function getRepo($entityName, $bundlename = "")
    {

        if ($bundlename == "") {
            $bundlename = "App";
        }

        return $this->entityManager->getRepository(sprintf('%s:%s', $bundlename, $entityName));
    }
}