<?php

namespace App\Service\ExcelTuneImport;

use App\Entity\TuneFileType;
use App\Service\ExcelTuneImport\Importer\ExcelImporterInterface;
use App\Service\Traits\GetRepoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Excel import tunes manager
 */
class ExcelImportTuneManager
{
    /**
     * @var array
     */
    private $excelImporters;

    public function __construct($excelImporters)
    {
        $this->excelImporters = $excelImporters;
    }

    /**
     * @param $name
     * @return ExcelImporterInterface
     */
    public function getImporterByName($name)
    {
        $importer = null;
        foreach ($this->excelImporters as $excelImporter) {
            if ($excelImporter->getName() === $name) {
                $importer = $excelImporter;
                break;
            }
        }

        if (null === $importer) {
            throw new \LogicException('Importer with name '.$name.' does not exist. Did you configured it in services.yml ?');
        }

        return $importer;
    }

    /**
     * @return array
     */
    public function getImportersNameList()
    {
        $list = [];
        foreach ($this->excelImporters as $excelImporter) {
                $list[] = $excelImporter->getName();
        }

        return $list;
    }


}
