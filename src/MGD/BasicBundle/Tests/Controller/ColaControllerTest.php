<?php

namespace MGD\BasicBundle\Tests\Controller;

use MGD\BasicBundle\DataFixtures\ORM\LoadColaData;
use MGD\FrameworkBundle\Tests\FunctionalTestCase;

class ColaControllerTest extends FunctionalTestCase
{
    private $url;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixturesGeneral();
        $this->url = $this->router->generate('contacto_es');
    }

    public function testCompleteScenario()
    {
        // Create a new entry in the database
        $crawler = $this->client->request('GET', $this->router->generate('home',array('locale'=>'en')));

        // Check data in the show view
        $this->assertEquals('Current Queue: 2 days.',
            trim($crawler->filter('div#cola')->text()), 'Missing element Current Queue'
        );

        // Create a new entry in the database
        $crawler = $this->client->request('GET', $this->router->generate('pedido_en'));

        // Check data in the show view
        $this->assertEquals('Current Queue: 2 days.',
            trim($crawler->filter('div#cola')->text()), 'Missing element Current Queue'
        );
    }

}