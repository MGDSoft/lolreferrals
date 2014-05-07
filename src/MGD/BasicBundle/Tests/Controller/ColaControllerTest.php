<?php

namespace MGD\BasicBundle\Tests\Controller;

use MGD\BasicBundle\DataFixtures\ORM\LoadColaData;
use MGD\BasicBundle\DataFixtures\ORM\LoadTestData;
use MGD\FrameworkBundle\Tests\FunctionalTestCase;

class ColaControllerTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadFixturesGeneral();
    }

    public function testCompleteScenario()
    {
        $crawler = $this->client->request('GET', $this->router->generate('home',array('locale'=>'en')));

        //$nDaysRemaining=round(LoadTestData::TOTAL_N_REFERIDOS / LoadColaData::REFERRALS_PER_DAY);
        $nDaysRemaining=0;

        // Check data in the show view
        $this->assertEquals("Current Queue: $nDaysRemaining days.",
            trim($crawler->filter('div#cola')->text()), 'Missing element Current Queue'
        );

        // Create a new entry in the database
        $crawler = $this->client->request('GET', $this->router->generate('pedido_en'));

        // Check data in the show view
        $this->assertEquals("Current Queue: $nDaysRemaining days.",
            trim($crawler->filter('div#cola')->text()), 'Missing element Current Queue'
        );
    }

}