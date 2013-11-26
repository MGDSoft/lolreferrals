<?php

namespace MGD\BasicBundle\Tests\Controller;

use Fixtures\Bundles\AnnotationsBundle\Entity\Test;
use MGD\FrameworkBundle\Tests\FunctionalTestCase;
use MGD\BasicBundle\DataFixtures\TestData;

class ContactoControllerTest extends FunctionalTestCase
{
    private $url;

    public static function setUpBeforeClass()
    {
        self::initialize();
    }

    public function setUp()
    {
        parent::setUp();
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

        $this->assertTrue($crawler->filter('div.alert-success')->count() < 1);
        $this->assertTrue($crawler->filterXPath('//form[@id="contacto"]//ul')->count() == 1);

    }

    public function testOK()
    {
        $crawler = $this->client->request('GET', $this->url );

        $form = $this->setValuesForm($crawler);


        $crawler = $this->client->submit($form);

        /*
        $repository = $this->om->getRepository('MGDBasicBundle:Pedido');
        $pedidos = $repository->findAll();

        foreach ($pedidos as $pedido)
        {
            echo $pedido->getId()."\n";
        }
        */
        $this->assertTrue($crawler->filter('div.alert-success')->count() == 1);

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');

        // Check that an e-mail was sent
        $this->assertEquals(1, $mailCollector->getMessageCount());
    }

    /*
        $repository = $this->om->getRepository('MGDFrameworkBundle:Usuario');
        $usuarios = $repository->findAll();

        foreach ($usuarios as $usuario)
        {
            echo $usuario->getUsername()."\n";
        }*/

    private function setValuesForm(
        $crawler,
        $nombre = 'test',
        $email = TestData::email,
        $pedidoId = TestData::pedidoId,
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