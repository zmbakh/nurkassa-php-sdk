<?php

namespace Nurkassa\HttpClients;

use Exception;
use Nurkassa\Exceptions\CouldNotConnectException;
use Nurkassa\Exceptions\ResponseWithErrorException;
use Nurkassa\Http\NurkassaRequest;
use Nurkassa\Http\NurkassaResponse;

class NurkassaCurlHttpClient implements NurkassaHttpClientInterface
{
    /**
     * @var NurkassaCurlService
     */
    protected $curlService;

    /**
     * @var string|bool The raw response from the server
     */
    protected $response;

    /**
     * NurkassaCurlHttpClient constructor.
     */
    public function __construct()
    {
        $this->curlService = new NurkassaCurlService();
    }

    /**
     * @param NurkassaRequest $request
     *
     * @throws \Exception
     *
     * @return NurkassaResponse
     */
    public function send(NurkassaRequest $request)
    {
        $this->openConnection($request);
        $this->executeRequest();

        if ($curlErrorCode = $this->curlService->errno()) {
            if ($this->curlService->errno() == 6) {
                throw new CouldNotConnectException($this->curlService->error());
            }

            throw new Exception($this->curlService->error(), $curlErrorCode);
        }

        list($headers, $body) = $this->getHeadersAndBody();

        $body = json_decode($body, true);

        $this->closeConnection();

        $response = new NurkassaResponse($headers, $body);

        if ($response->getStatusCode() >= 400) {
            $body = $response->getBody()['error'] ?? [];

            throw new ResponseWithErrorException($body['message'] ?? '', $response->getStatusCode(), $body['errors'] ?? []);
        }

        return $response;
    }

    /**
     * Opens a new curl connection.
     *
     * @param NurkassaRequest $request
     */
    public function openConnection(NurkassaRequest $request)
    {
        $options = [
            CURLOPT_CUSTOMREQUEST  => $request->getMethod(),
            CURLOPT_HTTPHEADER     => $this->makeCurlHeadersArray($request->getHeaders()),
            CURLOPT_URL            => $request->getUrl(),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => $request->getTimeout(),
            CURLOPT_RETURNTRANSFER => true, // Return response as string
            CURLOPT_HEADER         => true, // Enable header processing
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            //CURLOPT_CAINFO => __DIR__ . '/certs/RootCA.pem',
        ];

        if ($request->getMethod() !== 'GET') {
            $options[CURLOPT_POSTFIELDS] = $request->getBody();
        }

        $this->curlService->init();
        $this->curlService->setoptArray($options);
    }

    /**
     * Make a curl-friendly array of headers.
     *
     * @param array $headers The request headers.
     *
     * @return array
     */
    public function makeCurlHeadersArray(array $headers)
    {
        $return = [];

        foreach ($headers as $key => $value) {
            $return[] = $key.': '.$value;
        }

        return $return;
    }

    /**
     * Send the request.
     */
    public function executeRequest()
    {
        $this->response = $this->curlService->exec();
    }

    /**
     * Closes an existing curl connection.
     */
    public function closeConnection()
    {
        $this->curlService->close();
    }

    /**
     * Extracts the headers and the body into a two-part array.
     *
     * @return array
     */
    public function getHeadersAndBody()
    {
        $parts = explode("\r\n\r\n", $this->response);

        $body = array_pop($parts);
        $headers = implode("\r\n\r\n", $parts);

        return [trim($headers), trim($body)];
    }
}
