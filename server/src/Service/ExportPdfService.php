<?php

namespace App\Service;

use App\Entity\TuneFileType;
use App\Service\Traits\GetRepoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * export pdf service
 */
class ExportPdfService
{
    use GetRepoTrait;

    const GHOSTSCRIPT_EXECUTABLE = '/opt/bin/gs';
    const ORDER_ALPHA = 'alpha';
    const ORDER_TYPE = 'type';

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $rootPath;

    /**
     * @var string
     */
    private $tuneFilesPath;

    /**
     * ExportPdfService constructor.
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param string $rootPath
     * @param string $tuneFilesPath
     */
    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator, string $rootPath, string $tuneFilesPath)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
        $this->rootPath = $rootPath;
        $this->tuneFilesPath = $tuneFilesPath;
    }

    /**
     * export pdf pdf files in one
     * @param string $order
     * @return string
     */
    public function exportTunesPdf($order)
    {
        $partitionType = $this->getRepo('TuneFileType')->findOneBy(array('id' => TuneFileType::TUNE_FILE_TYPE_PARTITION_ID));

        if ($order === static::ORDER_ALPHA) {
            $tunesFiles = $this->getRepo('TuneFile')->findBy(array('tuneFileType' => $partitionType), array('name' => 'asc'));
        }
        if ($order === static::ORDER_TYPE) {
            // récupérer les tunefiles triés par tunetype de la tune
        }

        $tunesInfo = array();
        $counter = 1;
        $nbPages = 0;
        foreach ($tunesFiles as $tuneFile) {
            /* @var $tuneFile \App\Entity\TuneFile */
            $filePath = $this->rootPath.$this->tuneFilesPath.'/'.$tuneFile->getFileName();

            $pathParts = pathinfo($filePath);
            if ($pathParts['extension'] === 'pdf') {
                $nbPagesCourant = $this->countNbPages($filePath);
                $tunesInfo[] = array(
                    'name' => $tuneFile->getTune()->getName(),
                    'type' => $tuneFile->getTune()->getTuneType(),
                    'tags' => $tuneFile->getTune()->getTags(),
                    'filePath' => $filePath,
                    'nbPages' => $nbPagesCourant,
                    'pageNumber' => $counter + $nbPages,
                );

                // To get necessary shift on pageNumber
                $nbPages += $nbPagesCourant;
            }
        }

        return $this->mergePdfs($tunesInfo, $order);
    }

    /**
     * Returns the number of pages of a pdf file
     * @param string $path
     * @return int
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     */
    public function countNbPages($path)
    {
        $command = static::GHOSTSCRIPT_EXECUTABLE.' -q -c "('.$path.') (r) file runpdfbegin pdfpagecount = quit"';

        $process = new Process($command);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
        }

        return intval($process->getOutput());
    }

    /**
     * Merge the selected pdfs
     * @param array  $filesInfos FilesInfo est déjà trié, alpha, type ou tag
     * @param string $order
     * @return string the merge pdf path
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     */
    public function mergePdfs(array $filesInfos, $order)
    {
        // 1 - ordre alpha
        if ($order === static::ORDER_ALPHA) {
            $pdfmarksPath = $this->generateAlphaPdfMarks($filesInfos);
        }

        // 2 - par type
        if ($order === static::ORDER_TYPE) {
            $pdfmarksPath = $this->generateTypePdfMarks($filesInfos);
        }

        // 3 - par tag


        $pdfsToMerge = $this->getCommandLinePdfsToMerge($filesInfos);
        $mergedPath = $this->rootPath.$this->tuneFilesPath.'/MERGED.pdf';

        $command = static::GHOSTSCRIPT_EXECUTABLE.' -dBATCH -dNOPAUSE -sPAPERSIZE=letter -sDEVICE=pdfwrite -sOutputFile="'.$mergedPath.'" '.join(' ', $pdfsToMerge).' "'.$pdfmarksPath.'"';

        $process = new Process($command);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
        }

        $process->getOutput();

        return $mergedPath;
    }

    /**
     * Generate the pdfmarks file and give its path
     * @param array $filesInfos
     * @return string pdf marks path
     */
    protected function generateAlphaPdfMarks($filesInfos)
    {
        // 1 - Marks by alpha order
        $countTotalPages = $this->getTotalPages($filesInfos);
        $marks = array('[/Count '.$countTotalPages.' /Page 2 /Title ('.$this->translator->trans('export.pdf.toc.alpha.order').') /OUT pdfmark');
        foreach ($filesInfos as $fileInfos) {
            $marks[] = '[/Title ('.$fileInfos['name'].') /Page '.$fileInfos['pageNumber'].' /OUT pdfmark';
        }

        // create the pdf marks file
        $pdfmarksPath = $this->rootPath.$this->tuneFilesPath.'/pdfmarks';
        $fs = new Filesystem();
        try {
            $fs->dumpFile($pdfmarksPath, join("\n", $marks));
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while dumping pdfmarks file";
        }

        return $pdfmarksPath;
    }

    /**
     * Return the pdf paths to give to the ghostscript command line
     * @param array $filesInfos
     * @return array
     */
    protected function getCommandLinePdfsToMerge($filesInfos)
    {
        $pdfsToMerge = array();
        foreach ($filesInfos as $fileInfos) {
            $pdfsToMerge[] = '"'.$fileInfos['filePath'].'"';
        }

        return $pdfsToMerge;
    }

    /**
     * Returns the total number of pages
     * @param array $filesInfos
     * @return int
     */
    protected function getTotalPages($filesInfos)
    {
        $counter = 1;
        foreach ($filesInfos as $fileInfos) {
            $counter += $fileInfos['nbPages'];
        }

        return $counter;
    }
}
