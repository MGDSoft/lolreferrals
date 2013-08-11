<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\Articulo;
use MGD\BasicBundle\Form\PedidoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PedidoController extends Controller
{

	/**
     * @Route("/en/order/",defaults={"_locale" = "en"}, name="pedido_en")
     * @Route("/es/comprar/",defaults={"_locale" = "es"}, name="pedido_es")
	 * @Route("/de/bestellen/",defaults={"_locale" = "de"}, name="pedido_de")
     * @Template()
     */
    public function indexAction()
    {
	    $em = $this->getDoctrine()->getManager();

	    /** @var \MGD\BasicBundle\Entity\Articulo[] $articulos */
	    $articulos = $em->getRepository("MGDBasicBundle:Articulo")->findAll();

	    foreach($articulos as $articulo)
	    {
		    $this->setIpnVerificacionSiNoExiste($articulo);
	    }

	    return array(
		    'articulos' => $articulos,
	    );

    }


	private function setIpnVerificacionSiNoExiste(Articulo &$entity)
	{

		if (strpos($entity->getPaypalHtml(),'<input type="hidden" name="ipn_notify_url"')=== false)
		{
			$request = $this->getRequest();

			$baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

			$redirectsPostPaypal='
				    <input type="hidden" name="return" value="'.$baseUrl.$this->generateUrl('pagado',array('_locale' => $request->getLocale())).'">
					<input type="hidden" name="cancel_return" value="'.$baseUrl.$this->generateUrl('home').'">
					<input type="hidden" name="notify_url " value="'.$baseUrl.$this->generateUrl('validacion_ipn',array('_locale' => $request->getLocale())).'">
					<input type="hidden" name="ipn_notify_url" value="'.$baseUrl.$this->generateUrl('validacion_ipn').'" />
					</form>
				';

			$entity->setPaypalHtml(
				str_replace('</form>',$redirectsPostPaypal,$entity->getPaypalHtml())
			);
		}
	}

}
