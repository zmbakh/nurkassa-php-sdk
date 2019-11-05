<?php

namespace Nurkassa;

use Nurkassa\Http\NurkassaRequest;
use Nurkassa\Http\NurkassaResponse;
use Nurkassa\HttpClients\HttpClientFactory;

class Nurkassa
{
    /**
     * @const string Current SDK version
     */
    const CURRENT_SDK_VERSION = 'v1.0.0';

    /**
     * @var string Access token
     */
    private $access_token;

    /**
     * @var
     */
    protected $client;

    /**
     * Nurkassa constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'access_token' => null,
        ], $config);

        $this->access_token = $config['access_token'];

        $this->client = new NurkassaClient(
            HttpClientFactory::createHttpClient($config['http_client_handler'])
        );
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param NurkassaRequest $request
     *
     * @return NurkassaResponse
     */
    public function handleRequest(NurkassaRequest $request): NurkassaResponse
    {
        if ($this->access_token) {
            $request->addHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        }

        return $this->client->getHttpClient()->send($request);
    }

    /**
     * @param string $access_token
     *
     * @return Nurkassa
     */
    public function setAccessToken(string $access_token): self
    {
        $this->access_token = $access_token;

        return $this;
    }
}
