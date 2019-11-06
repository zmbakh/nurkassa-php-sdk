<?php

namespace Nurkassa\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Ring\Exception\RingException;
use Nurkassa\Http\NurkassaRequest;
use Nurkassa\Http\NurkassaResponse;

class NurkassaGuzzleHttpClient implements NurkassaHttpClientInterface
{
    /**
     * @var \GuzzleHttp\Client The Guzzle client.
     */
    protected $client;

    /**
     * NurkassaGuzzleHttpClient constructor.
     *
     * @param Client|null $guzzleClient
     */
    public function __construct(Client $guzzleClient = null)
    {
        $this->client = $guzzleClient ?: new Client();
    }

    /**
     * @param NurkassaRequest $request
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return NurkassaResponse
     */
    public function send(NurkassaRequest $request)
    {
        $options = [
            'headers'         => $request->getHeaders(),
            'body'            => $request->getBody(),
            'timeout'         => $request->getTimeout(),
            'connect_timeout' => 10,
            //'verify' => __DIR__ . '/certs/RootCA.pem',
        ];

        $request = $this->client->createRequest($request->getMethod(), $request->getUrl(), $options);

        try {
            $response = $this->client->send($request);
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($e->getPrevious() instanceof RingException || !$response instanceof ResponseInterface) {
                throw new \Exception($e->getMessage(), $e->getCode());
            }
        }

        $headers = $this->getHeadersAsString($response);
        $body = $response->getBody();
        $httpStatusCode = $response->getStatusCode();

        return new NurkassaResponse($headers, $body, $httpStatusCode);
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
            $rawHeaders[] = $name.': '.implode(', ', $values);
        }

        return implode("\r\n", $rawHeaders);
    }
}
