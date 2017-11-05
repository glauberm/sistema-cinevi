<?php

namespace Cinevi\ConfigBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Cinevi\AdminBundle\Command\BaseCommand;
use Cinevi\ConfigBundle\Entity\Config;

class ConfigCommand extends BaseCommand
{
    protected $name = 'generate:config';
    protected $description = 'Generate default configurations.';
    protected $help = 'This command generates the default configurations for the system.';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $config = $em->getRepository('CineviConfigBundle:Config')->findAll();

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
