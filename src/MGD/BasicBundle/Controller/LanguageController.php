<?php

namespace MGD\BasicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class LanguageController extends Controller {

	private $languageDispo= array('es','en');

	/**
	 * @Route("/language/change/{_locale}/", defaults={"_locale" = "en"}, name="cambiar_lenguaje")
	 */
	public function switchLanguageAction($_locale)
	{
        $request = $this->getRequest();

        if (in_array($_locale,$this->languageDispo))
        {
            $request->setLocale($_locale);
        }

        return $this->redirect($this->generateUrl('home') );
	}
}