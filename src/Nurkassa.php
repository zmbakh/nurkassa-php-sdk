<?php


namespace Nurkassa;


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
     * @param array $config
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
}