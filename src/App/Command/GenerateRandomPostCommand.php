<?php

namespace App\Command;

use Infrastructure\Service\PostGenerator\PostGeneratorService;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class GenerateRandomPostCommand extends Command
{
    protected static $defaultName = 'app:generate-random-post';
    protected static $defaultDescription = 'Run app:generate-random-post';

    private PostGeneratorService $postGeneratorService;

    public function __construct(string $name = null, PostGeneratorService $postGeneratorService)
    {
        parent::__construct($name);
        $this->postGeneratorService = $postGeneratorService;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->postGeneratorService->generatePostByDateTime(new DateTime());
            $output->writeln('A random post has been generated.');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            // log error
            $output->writeln('A random post had not been generated. Error: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }

}
