<?php

/**
 * File to improve speed with vagrant
 */

require_once __DIR__.'/AppKernel.php';

class AppKernelDev extends AppKernel
{
    public function getCacheDir()
    {
        if (in_array($this->environment, array('dev', 'test'))) {
            return '/tmp/mgd/lol/cache' .  $this->environment;
        }

        return parent::getCacheDir();
    }

    public function getLogDir()
    {
        if (in_array($this->environment, array('dev', 'test'))) {
            return '/tmp/mgd/lol/logs';
        }

        return parent::getLogDir();
    }

}
