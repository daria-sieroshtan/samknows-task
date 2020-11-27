<?php

namespace App\Service;

use App\Service\Exception\InputFileInvalidFormatException;
use App\Service\Exception\NoInputFilesException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class MultipleReportsGenerator
{
    private $parser;

    public function __construct(ColumnsExtractor $parser)
    {
        $this->parser = $parser;
    }

    public function generateReports($inputFolder, $outputFolder, $reportType, $loggingCallback)
    {
        $counter = 0;

        $filesystem = new Filesystem();
        $input = new Finder();
        $input->files()->in($inputFolder)->name('*.json');

        if ($input->hasResults()) {
            foreach ($input as $inputFile) {
                $output = new Finder();
                $output->files()->in($outputFolder);
                if ($output->name($inputFile->getFilenameWithoutExtension() . '.*')->hasResults()) {
                    // assuming that the presence of the output file with the same name means
                    // there is no need to generate new one. This behaviour could be changed based on business requirements
                    $loggingCallback(sprintf("Not generating report for the input file %s because the output file already exists", $inputFile->getFilename()));
                    continue;
                } else {
                        $inputContents = json_decode($inputFile->getContents(), true);
                    if ($inputContents === null) {
                        throw new InputFileInvalidFormatException(sprintf('File "%s" has invalid format.', $inputFile->getFilename()));
                    }
                    try {
                        $dataset = $this->parser->extractColumns($inputContents);
                    } catch (\Exception $e) {
                        throw new InputFileInvalidFormatException(sprintf('File "%s" has invalid format.', $inputFile->getFilename()));
                    }
                    try {
                        $renderedReport = ReportFactory::createReport($dataset, $reportType)->getRenderedReport();
                    } catch (\InvalidArgumentException $e) {
                        throw $e;
                    } catch (\Exception $e) {
                        // there can be exception diversification and more sophisticated error handling, but for now just general exception is thrown
                        throw new \RuntimeException(sprintf('There was a problem with generating report based on input file %s', $inputFile->getFilename()));
                    }
                    try {
                        $filesystem->dumpFile($outputFolder . $inputFile->getFilenameWithoutExtension() . '.output', $renderedReport);
                    } catch (\Exception $e) {
                        throw new \RuntimeException(sprintf('There was a problem with saving output file for input file %s', $inputFile->getFilename()));
                    }
                    $counter += 1;
                }
            }
            return $counter;
        } else {
            throw new NoInputFilesException('No input files.');
        }
    }
}
