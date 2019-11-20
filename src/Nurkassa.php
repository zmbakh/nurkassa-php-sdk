<?php

namespace Nurkassa;

use Nurkassa\Authentication\AuthenticationService;
use Nurkassa\Exceptions\CouldNotAuthenticateException;
use Nurkassa\Http\NurkassaRequest;
use Nurkassa\Http\NurkassaResponse;
use Nurkassa\HttpClients\HttpClientFactory;

class Nurkassa
{
    /**
     * @const string The base API URL
     */
    const BASE_URL = 'https://nurkassa.kz/';

    /**
     * @const string Current SDK version
     */
    const CURRENT_SDK_VERSION = '1.2.3';

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
    protected $baseUrl;

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
            'base_url'     => self::BASE_URL,
        ], $config);

        $this->access_token = $config['access_token'];

        $this->baseUrl = $config['base_url'];

        if (mb_substr($this->baseUrl, -1) !== '/') {
            $this->baseUrl .= '/';
        }

        $this->client = new NurkassaClient(
            HttpClientFactory::createHttpClient(isset($config['http_client_handler']) ? $config['http_client_handler'] : null)
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
     * @throws Exceptions\ResponseWithErrorException
     *
     * @return NurkassaResponse
     */
    public function handleRequest(NurkassaRequest $request): NurkassaResponse
    {
        if ($this->access_token) {
            $request->addHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        }

        $validUrl = $this->makeValidUrl($request->getUrl(), $request->getVersion());

        $request->setUrl($validUrl);

        return $this->client->getHttpClient()->send($request);
    }

    /**
     * @param $url
     * @param int $version
     *
     * @return string
     */
    protected function makeValidUrl($url, int $version = 1)
    {
        if (strtolower(substr($url, 0, 4)) !== 'http') {
            if ($url[0] === '/') {
                $url = mb_substr($url, 1);
            }

            $url = $this->baseUrl.'api/v'.$version.'/'.$url;
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
     * @throws CouldNotAuthenticateException
     * @throws Exceptions\ResponseWithErrorException
     *
     * @return NurkassaResponse
     */
    public function authenticate(string $phoneNumber, string $password)
    {
        $response = $this->handleRequest(AuthenticationService::request($phoneNumber, $password));
        $errors = AuthenticationService::checkForErrors($response);

        if ($errors === null) {
            $this->access_token = AuthenticationService::getAccessToken($response);

            return $response;
        } else {
            throw new CouldNotAuthenticateException('Can\'t authenticate. The status code of the response: '.$response->getStatusCode());
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
     * @param mixed $baseUrl
     *
     * @return Nurkassa
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }
}
