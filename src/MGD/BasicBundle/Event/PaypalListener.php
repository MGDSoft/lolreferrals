<?php
/**
 * Created by lol.
 * User: PC
 * Date: 2/08/13
 * Time: 1:10
 */

namespace MGD\BasicBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;

class PaypalListener {

	private $om;

	public function __construct(ObjectManager $om) {
		$this->om = $om;
	}

	public function onIPNReceive(PayPalEvent $event) {
		$ipn = $event->getIPN();
		// do your stuff
	}
}