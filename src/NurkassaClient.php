<?php


namespace Nurkassa;


use Nurkassa\HttpClients\NurkassaHttpClientInterface;

class NurkassaClient
{
    /**
     * @const string The base API URL
     */
    const BASE_API_URL = 'https://nurkassa.kz/api/v1/';

    /**
     * @const string The root URL of the website
     */
    const BASE_ROOT_URL = 'https://nurkassa.kz/';

    /**
     * @var NurkassaHttpClientInterface
     */
    protected $httpClient;

    /**
     * NurkassaClient constructor.
     * @param NurkassaHttpClientInterface|null $client
     */
    public function __construct(NurkassaHttpClientInterface $client = null)
    {
        $this->httpClient = $client;
    }
}