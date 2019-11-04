<?php

namespace Nurkassa\HttpClients;

use Nurkassa\Http\NurkassaResponse;

use GuzzleHttp\Client;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Ring\Exception\RingException;
use GuzzleHttp\Exception\RequestException;

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

    /**
     * Send a get request to the Nurkassa server
     * and return the response.
     *
     * @param $url
     * @param $headers
     * @return mixed
     */
    public function get(string $url, array $headers = [])
    {

    }

    /**
     * Send a post request.
     *
     * @param $url
     * @param $body
     * @param $headers
     * @param bool $multipart
     * @return mixed
     */
    public function post(string $url, array $body, array $headers = [], bool $multipart = false)
    {

    }

    /**
     * Send a put request.
     *
     * @param string $url
     * @param array $body
     * @param array $headers
     * @param bool $multipart
     * @return mixed
     */
    public function put(string $url, array $body, array $headers = [], bool $multipart = false)
    {

    }

    /**
     * Send a delete request.
     *
     * @param string $url
     * @param array $headers
     * @return mixed
     */
    public function delete(string $url, array $headers = [])
    {

    }


    /**
     * @param $url
     * @param $method
     * @param array $body
     * @param array $headers
     * @param int $timeOut
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return NurkassaResponse
     */
    public function request($url, $method, array $body, array $headers, int $timeOut)
    {
        $options = [
            'headers' => $headers,
            'body' => $body,
            'timeout' => $timeOut,
            'connect_timeout' => 10,
            //'verify' => __DIR__ . '/certs/RootCA.pem',
        ];

        $request = $this->client->createRequest($method, $url, $options);

        try {
            $rawResponse = $this->client->send($request);
        } catch (RequestException $e) {
            $rawResponse = $e->getResponse();

            if ($e->getPrevious() instanceof RingException || !$rawResponse instanceof ResponseInterface) {
                throw new \Exception($e->getMessage(), $e->getCode());
            }
        }

        $rawHeaders = $this->getHeadersAsString($rawResponse);
        $rawBody = $rawResponse->getBody();
        $httpStatusCode = $rawResponse->getStatusCode();

        return new NurkassaResponse($rawHeaders, $rawBody, $httpStatusCode);
    }


    /**
     * Returns the Guzzle array of headers as a string.
     *
     * @param ResponseInterface $response The Guzzle response.
     *
     * @return string
     */
    public function getHeadersAsString(ResponseInterface $response)
    {
        $headers = $response->getHeaders();
        $rawHeaders = [];
        foreach ($headers as $name => $values) {
            $rawHeaders[] = $name . ": " . implode(", ", $values);
        }

        return implode("\r\n", $rawHeaders);
    }
}