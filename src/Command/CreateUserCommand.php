<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    protected static $defaultDescription = 'Command to create user.';

    public function __construct(
        private HttpClientInterface $httpClient
    )
    {
        parent::__construct();

    }


    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the user.')
            ->addArgument('job', InputArgument::REQUIRED, 'job of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'User create command',
            '============',
            '',
        ]);

        $response = $this->httpClient->request(
            'POST',
            'https://reqres.in/api/users/',
            ['body' => [
                'name' => $input->getArgument('name'),
                'job' => $input->getArgument('job')
            ]]
        );

        $output->writeln('JSON: ' . $response->getContent());
        if ($response->getStatusCode() !== 201) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
