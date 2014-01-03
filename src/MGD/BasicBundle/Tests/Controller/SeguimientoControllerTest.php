<?php

namespace MGD\BasicBundle\Tests\Controller;

use Fixtures\Bundles\AnnotationsBundle\Entity\Test;
use MGD\FrameworkBundle\Tests\FunctionalTestCase;
use MGD\BasicBundle\DataFixtures\TestData;

class SeguimientoControllerTest extends FunctionalTestCase
{
    private $url;

    public static function setUpBeforeClass()
    {
        self::initialize();
    }

    public function setUp()
    {
        parent::setUp();
        $this->url = $this->router->generate('seguimiento_es');
    }

    public function testRequiredValuesValidation()
    {
        $crawler = $this->client->request('GET', $this->url );

        $form = $this->setValuesForm($crawler,'',false);

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('div.alert-success')->count() < 1);
        $this->assertTrue($crawler->filterXPath('//form[@id="contacto"]//ul')->count() == 1);

    }

    public function testWrongIdValidation()
    {
        $crawler = $this->client->request('GET', $this->url );

        $form = $this->setValuesForm($crawler,'REFX123',true);

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('div.alert-success')->count() < 1);
        $this->assertTrue($crawler->filterXPath('//form[@id="contacto"]//ul')->count() == 1);

    }

    public function testOK()
    {
        $crawler = $this->client->request('GET', $this->url );

        $form = $this->setValuesForm($crawler);

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('#seguimiento')->count() == 1);

    }

    private function setValuesForm($crawler,$pedidoId = TestData::pedidoId,$captcha=true)
    {
        if ($captcha)
        {
            $session = $this->container->get('session');
            $captcha = $session->get('gcb_captcha')['phrase'];
        }

        return $crawler->selectButton('Seguimiento del pedido')->form(array(
                'mgd_basicbundle_seguimientotype[pedidoId]'  => $pedidoId,
                'mgd_basicbundle_seguimientotype[captcha]'  => $captcha
            )
        );
    }

}