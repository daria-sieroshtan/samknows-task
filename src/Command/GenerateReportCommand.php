<?php

namespace App\Command;

use App\Service\MultipleReportsGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateReportCommand extends Command
{
    // hardcoded currently but can be changed later to be passed as an argument of the command
    const INPUT_FOLDER_DEFAULT = 'public/inputs/';
    const OUTPUT_FOLDER_DEFAULT = 'public/outputs/';
    const REPORT_TYPE_DEFAULT = 'short';

    private $multipleReportsGenerator;

    public function __construct(MultipleReportsGenerator $generator, $name = null)
    {
        parent::__construct($name);
        $this->multipleReportsGenerator = $generator;
    }


    protected function configure()
    {
        $this
            ->setName('app:generate-reports')
            ->addArgument('report_type', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reportType = $input->getArgument('report_type') ?? self::REPORT_TYPE_DEFAULT;

        try {
            $outputData = $this->multipleReportsGenerator->generateReports(
                self::INPUT_FOLDER_DEFAULT,
                self::OUTPUT_FOLDER_DEFAULT,
                $reportType,
                function ($logString) use ($output) {
                    $output->writeln('<comment>' . $logString . '</comment>');
                }
            );
            $output->writeln([
                '<info>All input files were processed successfully.</info>',
                sprintf('<info>Number of output files generated: %s</info>', $outputData)
            ]);
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln([
                    '<error>' . $e->getMessage() . '</error>',
                    '<error>Output generating failed.</error>']);
            return Command::FAILURE;
        }
    }
}
