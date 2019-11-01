<?php


namespace Nurkassa\HttpClients;


use GuzzleHttp\Client;

class NurkassaGuzzleHttpClient implements NurkassaHttpClientInterface
{
    /**
     * @var \GuzzleHttp\Client The Guzzle client.
     */
    protected $client;

    /**
     * NurkassaGuzzleHttpClient constructor.
     * @param Client|null $guzzleClient
     */
    public function __construct(Client $guzzleClient = null)
    {
        $this->client = $guzzleClient ?: new Client();
    }

    public function send() {

    }
}