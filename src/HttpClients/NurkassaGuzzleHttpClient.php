<?php

namespace Nurkassa\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Nurkassa\Exceptions\CouldNotConnectException;
use Nurkassa\Exceptions\ResponseWithErrorException;
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
     * @throws CouldNotConnectException
     * @throws GuzzleException
     * @throws ResponseWithErrorException
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

        try {
            $response = $this->client->request($request->getMethod(), $request->getUrl(), $options);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorResponse = $e->getResponse();
                $body = json_decode((string) $errorResponse->getBody(), true);
                $body = $body['error'] ?? [];
                throw new ResponseWithErrorException($body['message'] ?? '', $errorResponse->getStatusCode(), $body['errors']);
            } else {
                throw new CouldNotConnectException($e->getMessage());
            }
        }

        $headers = $this->getHeadersAsString($response);
        $body = (string) $response->getBody();

        $body = json_decode($body, true);

        $httpStatusCode = $response->getStatusCode();

        return new NurkassaResponse($headers, $body, $httpStatusCode);
    }

    /**
     * Returns the Guzzle array of headers as a string.
     *
     * @param Psr7\Response $response The Guzzle response.
     *
     * @return string
     */
    public function getHeadersAsString(Psr7\Response $response)
    {
        $headers = $response->getHeaders();
        $rawHeaders = [];
        foreach ($headers as $name => $values) {
            $rawHeaders[] = $name.': '.implode(', ', $values);
        }

        return implode("\r\n", $rawHeaders);
    }
}
