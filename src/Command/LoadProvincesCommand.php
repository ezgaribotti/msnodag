<?php

namespace App\Command;

use App\Services\ProvinceService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-provinces',
    description: 'Buscar y guardar provincias',
)]
class LoadProvincesCommand extends Command
{
    public function __construct(
        protected ProvinceService $provinceService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->provinceService->load();
        } catch (\Exception $exception) {

            $io->error($exception->getMessage());
            return Command::FAILURE;
        }

        $io->success('Provincias guardadas con éxito.');

        return Command::SUCCESS;
    }
}
