<?php
/**
 * Created by MGDSoftware. 6/03/14
 */

namespace MGD\BasicBundle\Tests\Entity;

use MGD\BasicBundle\Entity\PaypalAccount;

class TestPaypalAccountHelper
{
    static public function setValues(PaypalAccount $ppAccount, $active=true, $name='Alias', $username='Username'
        , $dineroParaRotar=1000, $password='Password', $signature='Signature')
    {

        $ppAccount
            ->setActive($active)
            ->setName($name)
            ->setApiUsername($username)
            ->setDineroParaRotar($dineroParaRotar)
            ->setApiPassword($password)
            ->setApiSignature($signature)
        ;
    }

} 