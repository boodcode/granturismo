<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use League\Csv\Reader;

#[AsCommand(
    name: 'import_csv_data',
    description: 'Add a short description for your command',
)]
class ImportCsvDataCommand extends Command
{
    protected static $defaultName = 'app:import-csv-users';
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $csvFile = "../src/Datas/users/csv";
        $reader = Reader::createFromPath($csvFile);
        $reader->setDelimiter(';');

        $records = $reader->getRecords();

        foreach ($records as $record) {
            $user = new User();
            $user
                ->setEmail($record->email)
                ->setUsername($record->username)
                ->setPassword(substr($record->username, 0, 1).'2023')
                ->setRoles(['ROLE_USER']);
            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
