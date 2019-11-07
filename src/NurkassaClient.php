<?php

namespace Nurkassa;

use Nurkassa\HttpClients\NurkassaHttpClientInterface;

class NurkassaClient
{
    /**
     * @var NurkassaHttpClientInterface
     */
    protected $httpClient;

    /**
     * NurkassaClient constructor.
     *
     * @param NurkassaHttpClientInterface|null $client
     */
    public function __construct(NurkassaHttpClientInterface $client = null)
    {
        $this->httpClient = $client;
    }

    /**
     * @return NurkassaHttpClientInterface
     */
    public function getHttpClient(): NurkassaHttpClientInterface
    {
        return $this->httpClient;
    }
}
