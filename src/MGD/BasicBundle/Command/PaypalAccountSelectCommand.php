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

class PaypalAccountSelectCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('paypal:account:set')
            ->setDescription('Set valid account')
            ->addArgument('name', InputArgument::REQUIRED, 'Name Paypal')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        if (!$ppPaypalAccount = $em->getRepository('MGDBasicBundle:PaypalAccount')->findOneByName($name))
            return false;

        if ($ppPaypalAccount->getActive())
            return true;

        $ppPaypalAccount->setActive(true);
        $em->persist($ppPaypalAccount);

        $em->flush();
    }
}