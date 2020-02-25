<?php

namespace App\Command;

use App\Flyaround\FlyschemaSchema\Airport;
use App\Flyaround\FlyschemaSchema\AirportModel;
use DateTime;
use PommProject\Foundation\Pomm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\convertCsvToArrayService;


class ImportCommand extends Command
{
    private $convert;
    private $pomm;
    private $airportModel;

    public function __construct(ConvertCsvToArrayService $convert, Pomm $pomm, AirportModel $airportModel)
    {
        $this->convert = $convert;
        $this->pomm = $pomm;
        $this->airportModel = $airportModel;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('import:csv')
            ->setDescription('imports a csv file with list of french airports');   
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Loading the data...');
        $now = new DateTime;
        $io->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        $this->import($input, $output);

        $io->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
        $io->success('The import is done and command exited cleanly!');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        $data = $this->getCsv($input, $output);
        $size = count($data);
        $progress = new ProgressBar($output, $size);
        $progress->start();

        foreach ($data as $row) {
            $airport = new Airport([
                'name' => $row['name'],
                'icao' => $row['icao'],
                'coordinates' => $row['latitude'] . ", " . $row['longitude'],
                'address' => $row['adress'],
                'city' => $row['city'],
                'country' => $row['country']
            ]);

            $this->pomm
                ->getDefaultSession()
                ->getModel(AirportModel::class)
                ->insertOne($airport);
        }

        $progress->finish();


    }

    protected function getCsv(InputInterface $input, OutputInterface $output)
    {
        $filename = 'french-airports.csv';
        $data = $this->convert->convert($filename, ';');
        return $data;
    }
}