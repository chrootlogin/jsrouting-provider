<?php

namespace rootLogin\JSRoutingProvider\Command;

use rootLogin\JSRoutingProvider\JSRoutingProvider;
use Saxulum\Console\Command\AbstractPimpleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpRouterCommand extends AbstractPimpleCommand
{
    protected function configure()
    {
        $this
            ->setName('jsrouting:dump:router')
            ->setDescription('dumps the router.js javascript')
        ;
    }

    /**
     * @param  InputInterface    $input
     * @param  OutputInterface   $output
     * @return int|null|void
     * @throws \RuntimeException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jsrp = new JSRoutingProvider($this->container);
        $output->writeln($jsrp->getJavaScript());
    }
}