<?php
/**
 * Created by MGDSoftware. 6/03/14
 */

namespace MGD\BasicBundle\Tests\Listener\Entity;


use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Tests\Entity\TestPaypalAccountHelper;
use MGD\FrameworkBundle\Tests\KernelAwareTest;

class PaypalAccountEntityListenerTest extends KernelAwareTest
{
    public function testAutoOrderNOK()
    {
        $paypalAccount = new PaypalAccount();
        $paypalAccount2 = new PaypalAccount();
        $paypalAccount3 = new PaypalAccount();
        $paypalAccount4 = new PaypalAccount();

        TestPaypalAccountHelper::setValues($paypalAccount);
        TestPaypalAccountHelper::setValues($paypalAccount2, false, 'name2','username2');
        TestPaypalAccountHelper::setValues($paypalAccount3, false, 'name3','username3');
        TestPaypalAccountHelper::setValues($paypalAccount4, false, 'name4','username4');

        $this->em->persist($paypalAccount);
        $this->em->persist($paypalAccount2);
        $this->em->flush();

        $this->assertEquals(1,$paypalAccount->getOrderN());
        $this->assertEquals(2,$paypalAccount2->getOrderN());

        $this->em->persist($paypalAccount3);
        $this->em->flush();

        $this->em->persist($paypalAccount4);
        $this->em->flush();

        $this->assertEquals(3,$paypalAccount3->getOrderN());
    }

    public function testUniqueActiveOK()
    {
        $paypalAccount = new PaypalAccount();
        $paypalAccount2 = new PaypalAccount();
        $paypalAccount3 = new PaypalAccount();

        TestPaypalAccountHelper::setValues($paypalAccount);
        TestPaypalAccountHelper::setValues($paypalAccount2, true, 'name2','username2');
        TestPaypalAccountHelper::setValues($paypalAccount3, true, 'name3','username3');

        $this->em->persist($paypalAccount);
        $this->em->persist($paypalAccount2);
        $this->em->flush();


        $this->assertFalse($paypalAccount->getActive());
        $this->assertTrue($paypalAccount2->getActive());

        $this->em->persist($paypalAccount3);
        $this->em->flush();

        $this->assertFalse($paypalAccount->getActive());
        $this->assertFalse($paypalAccount2->getActive());
        $this->assertTrue($paypalAccount3->getActive());
    }

} 