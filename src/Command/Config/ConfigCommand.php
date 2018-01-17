<?php

namespace App\Command\Config;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Config;

class ConfigCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('generate:config')
            ->setDescription('Generate default configurations.')
            ->setHelp('This command generates the default configurations for the system.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->em->getRepository(Config::class)->findAll();

        if(!$config) {
            $config = new Config();

            $config->setReservasFechadas(false);
            $config->setMensagemCopiaFinal(null);

            $this->em->persist($config);
            $this->em->flush();

            $output->writeln('Configurations successfully generated.');
        } else {
            $output->writeln('Configurations already generated.');
        }
    }
}
