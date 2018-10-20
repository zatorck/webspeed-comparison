<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 20/10/2018
 * Time: 11:13
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppControllerTest extends WebTestCase
{
    /**
     * This metod check home response code
     */
    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * This test check method allowed
     */
    public function testAnalyzeGet()
    {
        $client = static::createClient();

        $client->request('GET', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());


        $client->request('HEAD', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('PUT', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('DELETE', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('CONNECT', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('OPTIONS', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('TRACE', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('PATCH', '/analyze');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * This test check positive data
     */
    public function testAnalyze()
    {
        $client = static::createClient();

        $client->request(
                'POST',
                '/analyze',
                [
                        'email'          => 'example@example.com',
                        'phoneNumber'    => '000000000',
                        'main'           => 'https://www.facebook.com/?ref=logo',
                        'additionalUrls' => 'https://symfony.com/doc/current/testing.html_-_-_',
                ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}