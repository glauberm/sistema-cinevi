<?php

namespace Cinevi\AdminBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends ContainerAwareCommand
{
    protected $name;
    protected $description;
    protected $help;

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description)
            ->setHelp($this->help)
        ;
    }
}
