<?php

namespace MGD\BasicBundle\Tests\Controller;

use MGD\BasicBundle\Entity\Estado;
use MGD\FrameworkBundle\Tests\FunctionalTestCase;
use MGD\BasicBundle\DataFixtures\ORM\LoadTestData;


class ContactoControllerTest extends FunctionalTestCase
{
    private $url;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixturesGeneral();
        $this->url = $this->router->generate('contacto_es');
    }

    public function testRequiredValuesValidation()
    {
        $crawler = $this->client->request('GET', $this->url );

        $form = $this->setValuesForm($crawler,'','','','',false);

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('div.alert-success')->count() < 1);
        $this->assertTrue($crawler->filterXPath('//form[@id="contacto"]//ul')->count() == 4);

    }

    public function testWrongIdValidation()
    {
        $crawler = $this->client->request('GET', $this->url );

        $form = $this->setValuesForm($crawler,'test','test@test.com','REFX123');

        $crawler = $this->client->submit($form);

        //$this->mostrarHtml($crawler);

        $this->assertTrue($crawler->filter('div.alert-success')->count() < 1);
        $this->assertTrue($crawler->filterXPath('//form[@id="contacto"]//ul')->count() == 1);

    }

    public function testOK()
    {
        $crawler = $this->client->request('GET', $this->url );

        $form = $this->setValuesForm($crawler);

        $crawler = $this->client->submit($form);

        //$this->mostrarHtml($crawler);
        $this->assertTrue($crawler->filter('div.alert-success')->count() == 1);

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');

        // Check that an e-mail was sent
        $this->assertEquals(1, $mailCollector->getMessageCount());
    }

    private function setValuesForm(
        $crawler,
        $nombre = 'test',
        $email = LoadTestData::EMAIL,
        $pedidoId = LoadTestData::PEDIDO_ID,
        $mensaje = 'test',
        $captcha = true
    ){

        if ($captcha)
        {
            $session = $this->container->get('session');
            $captcha = $session->get('gcb_captcha')['phrase'];
        }

        return $crawler->selectButton('Enviar Mensaje')->form(array(
                'mgd_basicbundle_contactotype[nombre]'  => $nombre,
                'mgd_basicbundle_contactotype[email]'  => $email,
                'mgd_basicbundle_contactotype[pedidoId]'  => $pedidoId,
                'mgd_basicbundle_contactotype[mensaje]'  => $mensaje,
                'mgd_basicbundle_contactotype[captcha]'  => $captcha
            )
        );
    }

}