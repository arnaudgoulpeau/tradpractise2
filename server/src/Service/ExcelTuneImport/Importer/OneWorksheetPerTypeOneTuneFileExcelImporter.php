<?php

namespace App\Service\ExcelTuneImport\Importer;

use App\Entity\Tag;
use App\Entity\Tune;
use App\Entity\TuneFile;
use App\Entity\TuneFileType;
use App\Entity\TuneType;
use Doctrine\ORM\EntityManagerInterface;
use Liuggio\ExcelBundle\Factory;
use Psr\Log\LoggerInterface;

/**
 * Excel importer that can be configured to map index with properties but create a single external link tuneFile
 */
class OneWorksheetPerTypeOneTuneFileExcelImporter implements ExcelImporterInterface
{
    const CONF_TUNE_NAME = 'tuneName';
    const CONF_TUNE_KEY = 'tuneKey';
    const CONF_TUNE_FILE_NAME = 'tuneFileName';
    const CONF_TUNE_LINK_WEB = 'tuneFileLinkweb';
    const CONF_HAS_HEADER = 'hasHeader';
    const CONF_APPLY_TAGS = 'applyTags';

    /**
     * @var Factory
     */
    private $phpExcel;

    /**
     * @var string
     */
    private $serviceName;

    /**
     * @var array
     */
    private $config;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * OneWorksheetPerTypeOneTuneFileExcelImporter constructor.
     * @param string $serviceName
     * @param Factory $phpExcel
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(string $serviceName, Factory $phpExcel, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->serviceName = $serviceName;
        $this->phpExcel = $phpExcel;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * Import from file path
     * @param string $path
     * @param array $config
     * @throws \PHPExcel_Exception
     */
    public function import($path, array $config)
    {
        $this->config = $config;
        $objPHPExcel = $this->phpExcel->createPHPExcelObject($path);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $this->handleWorksheet($worksheet);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->serviceName;
    }

    /**
     * Use the worksheet to get tunes. If no config available, do nothing
     * @param \PHPExcel_Worksheet $worksheet
     * @throws \PHPExcel_Exception
     */
    protected function handleWorksheet(\PHPExcel_Worksheet $worksheet)
    {
        $this->logger->info('-------------------------------------------------');
        $this->logger->info('Processing sheet : '.$worksheet->getTitle());
        $this->logger->info('-------------------------------------------------');

        $worksheetConfig = $this->getWorksheetConfig($worksheet->getTitle());

        if ($worksheetConfig) {
            $this->handleRows($worksheet, $worksheetConfig);
        } else {
            $this->logger->warning('No config found for sheet : '.$worksheet->getTitle());
        }
    }

    /**
     * For a worksheet, iterate over row to get tunes. Exclude header if specified
     * @param \PHPExcel_Worksheet $worksheet
     * @param array               $worksheetConfig
     * @throws \PHPExcel_Exception
     */
    protected function handleRows(\PHPExcel_Worksheet $worksheet, array $worksheetConfig)
    {
        foreach ($worksheet->getRowIterator() as $row) {
            if ($row->getRowIndex() === 1 && $this->config[static::CONF_HAS_HEADER]) {
                continue;
            }

            $this->handleRow($worksheet, $row->getRowIndex(), $worksheetConfig);
        }
    }

    /**
     * Handle a specific row to create a Tune & associated entities
     * @param \PHPExcel_Worksheet $worksheet
     * @param int $rowIndex
     * @param array $worksheetConfig
     * @throws \PHPExcel_Exception
     */
    protected function handleRow(\PHPExcel_Worksheet $worksheet, int $rowIndex, array $worksheetConfig)
    {
        $tuneName = $this->calculateCellValue($worksheet, $rowIndex, $worksheetConfig[static::CONF_TUNE_NAME]);
        $tuneKey = $this->calculateCellValue($worksheet, $rowIndex, $worksheetConfig[static::CONF_TUNE_KEY]);
        $tuneFileName = $this->calculateCellValue($worksheet, $rowIndex, $worksheetConfig[static::CONF_TUNE_FILE_NAME]);
        $tuneFileLinkweb = $this->calculateCellValue($worksheet, $rowIndex, $worksheetConfig[static::CONF_TUNE_LINK_WEB]);

        if ($tuneName) {
            $this->logger->info('Tune name : ' . $tuneName);
            $this->logger->info('Tune key : ' . $tuneKey);
            $this->logger->info('Tune file name: ' . $tuneFileName);
            $this->logger->info('Tune file link web : ' . $tuneFileLinkweb);


            // search for tune in DB, ignore it if already there
            if (null !== $this->entityManager->getRepository(Tune::class)->findOneBy(['name' => $tuneName])){
                $this->logger->warning('Tune '.$tuneName.' already exist in DB. SKIP');
            } else {
                $this->createTuneFromInfos($tuneName, $tuneKey, $tuneFileName, $worksheetConfig['tuneType'], $tuneFileLinkweb);
            }
            $this->logger->info('-----');
        }
    }

    /**
     * @param string $tuneName
     * @param string $tuneKey
     * @param string $tuneFileName
     * @param string $tuneFileLinkweb
     */
    protected function createTuneFromInfos(string $tuneName, string $tuneKey, string $tuneFileName, TuneType $tuneType, string $tuneFileLinkweb = null)
    {
        $tagsConfig = $this->config[static::CONF_APPLY_TAGS];
        $tags = $this->entityManager->getRepository(Tag::class)->findByNameIn($tagsConfig);

        $tune = new Tune();
        $tune
            ->setName($tuneName)
            ->setTuneType($tuneType)
            ->setKey($tuneKey)
            ->addTags($tags)
        ;

        $tuneFileType = $this->entityManager->getRepository(TuneFileType::class)->find(TuneFileType::TUNE_FILE_TYPE_LINKWEB_ID);

        $tuneFile = new TuneFile();
        $tuneFile
            ->setName($tuneFileName)
            ->setLink($tuneFileLinkweb)
            ->setTuneFileType($tuneFileType)
            ->setTune($tune)
        ;

        $tune->addTuneFile($tuneFile);

        $this->entityManager->persist($tune);
        $this->entityManager->flush();
        $this->logger->info('Tune saved !');
    }

    /**
     * @param \PHPExcel_Worksheet $worksheet
     * @param int $rowIndex
     * @param $config
     * @return mixed|string
     * @throws \PHPExcel_Exception
     */
    protected function calculateCellValue(\PHPExcel_Worksheet $worksheet, int $rowIndex, $config)
    {
        $value = '';
        if (is_array($config)) {
            $values = [];
            foreach ($config as $column) {
                $values[] = $worksheet->getCell($column.$rowIndex)->getValue();
            }
            $value = join(' - ', $values);
        } else {
            $value = $worksheet->getCell($config.$rowIndex)->getValue();
        }

        return $value;
    }

    /**
     * @param string $worksheetTitle
     * @return array|null
     */
    protected function getWorksheetConfig(string $worksheetTitle)
    {
        $worksheetConfig = null;
        foreach ($this->config['worksheetMapping'] as $tuneTypeLabel => $worksheetMapping) {
            if ($worksheetMapping['worksheetTitle'] === $worksheetTitle) {
                $worksheetConfig = $worksheetMapping;
                $worksheetConfig['tuneType'] = $this->entityManager->getRepository(TuneType::class)->findOneBy(['name' => $tuneTypeLabel]);
                break;
            }
        }

        return $worksheetConfig;
    }
}
