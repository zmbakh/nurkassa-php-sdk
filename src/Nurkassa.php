<?php

namespace Nurkassa;

use Nurkassa\Authentication\AuthenticationService;
use Nurkassa\Http\NurkassaRequest;
use Nurkassa\Http\NurkassaResponse;
use Nurkassa\HttpClients\HttpClientFactory;

class Nurkassa
{
    /**
     * @const string The base API URL
     */
    const BASE_API_URL = 'https://nurkassa.kz/api/v1/';

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
     * @var
     */
    protected $baseApiUrl;



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
            'base_url' => self::BASE_API_URL,
        ], $config);

        $this->access_token = $config['access_token'];

        $this->baseApiUrl = $config['base_url'];

        if (mb_substr($this->baseApiUrl, -1) !== '/') {
            $this->baseApiUrl .= '/';
        }

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

        $validUrl = $this->makeValidUrl($request->getUrl());

        $request->setUrl($validUrl);

        return $this->client->getHttpClient()->send($request);
    }

    /**
     * @param $url
     *
     * @return string
     */
    protected function makeValidUrl($url)
    {
        if (strtolower(substr($url, 0, 4)) !== 'http') {
            if ($url[0] === '/') {
                $url = mb_substr($url, 1);
            }

            $url = $this->baseApiUrl.$url;
        }

        return $url;
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

    /**
     * @param string $phoneNumber
     * @param string $password
     *
     * @throws \Exception
     */
    public function authenticate(string $phoneNumber, string $password)
    {
        $response = $this->handleRequest(AuthenticationService::request($phoneNumber, $password));
        $errors = AuthenticationService::checkForErrors($response);

        if ($errors === null) {
            $this->access_token = AuthenticationService::getAccessToken($response);
        } else {
            throw new \Exception('Can\'t authenticate. The status code of the response: '.$response->getStatusCode());
        }
    }

    /**
     * Removes access token. So you can send unauthenticated requests to the server.
     */
    public function logout()
    {
        $this->access_token = null;
    }

    /**
     * @param mixed $baseApiUrl
     * @return Nurkassa
     */
    public function setBaseApiUrl($baseApiUrl)
    {
        $this->baseApiUrl = $baseApiUrl;
        return $this;
    }
}
