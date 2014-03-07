<?php
/**
 * Created by MGDSoftware. 6/03/14
 */

namespace MGD\BasicBundle\Tests\Listener\Entity;


use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Entity\PaypalAccountsPayment;
use MGD\BasicBundle\Tests\Entity\TestPaypalAccountHelper;
use MGD\FrameworkBundle\Tests\KernelAwareTest;

class PaypalAccountEntityListenerTest extends KernelAwareTest
{

    public function testSumMoneyToAccount()
    {
        $paypalAccount = new PaypalAccount();

        TestPaypalAccountHelper::setValues($paypalAccount,true,'user','pass',100);
        $this->em->persist($paypalAccount);
        $this->em->flush();

        $payment = new PaypalAccountsPayment();

        $payment->setPrecio(50);
        $payment->setPaypalAccount($paypalAccount);

        $this->em->persist($payment);
        $this->em->flush();

        $this->assertEquals(50, $paypalAccount->getDineroAgregado());
        $this->assertEquals(50, $paypalAccount->getDineroAgregadoTotal());

        $payment2 = new PaypalAccountsPayment();
        $payment3 = new PaypalAccountsPayment();

        $payment2->setPrecio(5);
        $payment3->setPrecio(10);
        $payment2->setPaypalAccount($paypalAccount);
        $payment3->setPaypalAccount($paypalAccount);

        $this->em->persist($payment2);
        $this->em->persist($payment3);
        $this->em->flush();

        $this->assertEquals(65, $paypalAccount->getDineroAgregado());
        $this->assertEquals(65, $paypalAccount->getDineroAgregadoTotal());

    }

    public function testRotateIfExceedLimitPaypalAccount()
    {
        $paypalAccount = new PaypalAccount();
        $paypalAccount2 = new PaypalAccount();

        TestPaypalAccountHelper::setValues($paypalAccount, true,'user','pass',100);
        TestPaypalAccountHelper::setValues($paypalAccount2, false,'user2','pass2',51);

        $this->em->persist($paypalAccount);
        $this->em->persist($paypalAccount2);
        $this->em->flush();

        $payment = new PaypalAccountsPayment();

        $payment->setPrecio(102);
        $payment->setPaypalAccount($paypalAccount);

        $this->em->persist($payment);
        $this->em->flush();


        $this->assertEquals(2,$paypalAccount->getDineroAgregado());
        $this->assertFalse($paypalAccount->getActive());
        $this->assertTrue($paypalAccount2->getActive());


        $payment = new PaypalAccountsPayment();

        $payment->setPrecio(55);
        $payment->setPaypalAccount($paypalAccount2);

        $this->em->persist($payment);
        $this->em->flush();

        $this->assertEquals(4,$paypalAccount2->getDineroAgregado());
        $this->assertTrue($paypalAccount->getActive());
        $this->assertFalse($paypalAccount2->getActive());
    }

} 