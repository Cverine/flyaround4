<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 26/02/19
 * Time: 18:51
 */

namespace App\Command;

use App\Flyaround\FlyschemaSchema\AirportModel;
use App\Flyaround\FlyschemaSchema\Flight;
use App\Flyaround\FlyschemaSchema\FlightModel;
use App\Flyaround\FlyschemaSchema\User;
use App\Flyaround\FlyschemaSchema\UserModel;
use DateTime;
use Faker;
use PommProject\Foundation\Pomm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class FixtureLoadCommand extends Command
{
    private $pomm;

    public function __construct(Pomm $pomm)
    {
        $this->pomm = $pomm;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('fixture:load')
            ->setDescription('loads fixtures in database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        if (!$io->confirm('Careful, database will be purged. Do you want to continue?', !$input->isInteractive())) {
            return;
        }

/*        $fixtures = $this->fixturesLoader->getFixtures(); TODO gérer le message d'erreur si pas de fixtures
        if (!$fixtures) {
            $io->error('Could not find any fixture services to load.');

            return 1;
        }*/
$io->
        $now = new DateTime;
        $io->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        $io->title('Purging database...');
        $this->purge();
        $io->title('Loading fixtures...');
        $this->load();

        $io->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
        $io->success('The fixtures are recorded in db and command exited cleanly!');
    }

    private function purge()
    {
        /*$items = $this->pomm
                    ->getDefaultSession()
                    ->getModel(AirportModel::class)
                    ->findAll();
        foreach ($items as $item) {
            var_dump($item['city']);
        }*/
    }

    private function load()
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 11; $i++) {
            $user = new User([
                'created_at' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now'),
                'username' => $faker->userName,
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'password'  => $faker->password,
                'email' => $faker->freeEmail,
                'role' => 'pilot',
                'is_certified_pilot' => $faker->boolean
            ]);
            $this->pomm
                ->getDefaultSession()
                ->getModel(UserModel::class)
                ->insertOne($user);
        }

        for ($i = 0; $i < 10; $i++) {

            $flight = new Flight([
                'created_at' => $faker->dateTimeBetween($startDate = '-1 week', $endDate = 'now'),
                'takeoff_time' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month'),
                'landing_time' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month'),
                'depart_city'  => $this->extractRandomCity(),
                'arrival_city'  => $this->extractRandomCity(),
                'free_seats' => $faker->randomDigitNotNull,
                'seat_price'  => $faker->numberBetween($min = 50, $max = 1000),
                'pilot' => $this->extractRandomPilot(),
                'was_done' => $faker->boolean
            ]);
            $this->pomm
                ->getDefaultSession()
                ->getModel(FlightModel::class)
                ->insertOne($flight);
        }


    }

    private function extractRandomCity()
    {
        $airports = $this->pomm
            ->getDefaultSession()
            ->getModel(AirportModel::class)
            ->findAll();
        $cities = $airports->extract();
        $random = mt_rand(0, count($cities) - 1);
        $city = $cities[$random]['id'];

        return $city;
    }

    /**
     *
     *
     * @return void
     */
    private function extractRandomPilot()
    {
        $users = $this->pomm
            ->getDefaultSession()
            ->getModel(UserModel::class)
            ->findWhere("is_certified_pilot");
        $pilots = $users->extract();
        $random = mt_rand(0, count($pilots) - 1);
        $pilot = $pilots[$random]['id'];

        return $pilot;
    }

}
