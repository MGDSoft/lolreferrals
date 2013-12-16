<?php
/**
 * Created by lol.
 * User: PC
 * Date: 27/07/13
 * Time: 15:03
 */

namespace MGD\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController {
	/**
	 * Lists all Estado entities.
	 *
	 * @Route("/", name="default_admin")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		return array();
	}
}