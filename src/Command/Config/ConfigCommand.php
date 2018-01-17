<?php

namespace App\Command\Config;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Command\Admin\AbstractCommand;
use App\Entity\Config;

class ConfigCommand extends AbstractCommand
{
    protected $name = 'generate:config';
    protected $description = 'Generate default configurations.';
    protected $help = 'This command generates the default configurations for the system.';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $config = $em->getRepository(Config::class)->findAll();

        if(!$config) {
            $config = new Config();

            $config->setReservasFechadas(false);
            $config->setMensagemCopiaFinal(null);

            $em->persist($config);
            $em->flush();

            $output->writeln('Configurations successfully generated.');
        } else {
            $output->writeln('Configurations already generated.');
        }
    }
}
