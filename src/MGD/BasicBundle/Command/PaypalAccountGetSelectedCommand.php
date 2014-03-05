<?php
/**
 * Created by lol.
 * User: PC
 * Date: 20/11/13
 * Time: 14:12
 */

namespace MGD\BasicBundle\Command;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use MGD\BasicBundle\Service\PaypalAccountService;

class PaypalAccountGetSelectedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('paypal:account:get')
            ->setDescription('Get actual account')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getContainer()->getParameter('paypal_api_username'));
    }
}