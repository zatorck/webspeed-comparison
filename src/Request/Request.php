<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 17/10/2018
 * Time: 18:18
 */

namespace App\Request;


use GuzzleHttp\Client;

class Request
{

    /**
     * @var string
     */
    private $url;

    /**
     * @var Client
     */
    private $client;

    /**
     * Request constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->client = new Client();
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}