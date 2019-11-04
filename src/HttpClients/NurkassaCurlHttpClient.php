<?php


namespace Nurkassa\HttpClients;


use Nurkassa\Http\NurkassaResponse;
use Nurkassa\Nurkassa;
use Nurkassa\NurkassaClient;

class NurkassaCurlHttpClient implements NurkassaHttpClientInterface
{
    /**
     * @var NurkassaCurlService
     */
    protected $curlService;

    /**
     * @var string|boolean The raw response from the server
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
     * @param string $url
     * @param array $headers
     * @return mixed|void
     * @throws \Exception
     */
    public function get(string $url, array $headers = [])
    {
        return $this->request($url, 'GET', null, $headers, 60);
    }


    /**
     * @param string $url
     * @param array $body
     * @param array $headers
     * @param bool $multipart
     * @return mixed|void
     * @throws \Exception
     */
    public function post(string $url, array $body, array $headers = [], bool $multipart = false)
    {
        return $this->request($url, 'POST', $body, $headers, 60);
    }


    /**
     * @param string $url
     * @param array $body
     * @param array $headers
     * @param bool $multipart
     * @return mixed|void
     * @throws \Exception
     */
    public function put(string $url, array $body, array $headers = [], bool $multipart = false)
    {
        //TODO add _method=put

        return $this->request($url, 'POST', $body, $headers, 60);
    }


    /**
     * @param string $url
     * @param array $headers
     * @return mixed|void
     * @throws \Exception
     */
    public function delete(string $url, array $headers = [])
    {
        $body['_method'] = 'delete';
        return $this->request($url, 'POST', $body, $headers, 60);
    }

    /**
     * @param $url
     * @param $method
     * @param $body
     * @param $headers
     * @param int $timeOut
     * @return NurkassaResponse
     * @throws \Exception
     */
    public function request($url, $method, $body, $headers, int $timeOut = 60) {
        $this->openConnection($url, $method, $body, $headers, $timeOut);
        $this->executeRequest();

        if ($curlErrorCode = $this->curlService->errno()) {
            throw new \Exception($this->curlService->error(), $curlErrorCode);
        }

        list($headers, $body) = $this->getHeadersAndBody();

        $body = json_decode($body, true);

        $this->closeConnection();

        return new NurkassaResponse($headers, $body);
    }


    /**
     * Opens a new curl connection.
     *
     * @param string $url     The endpoint to send the request to.
     * @param string $method  The request method.
     * @param string $body    The body of the request.
     * @param array  $headers The request headers.
     * @param int    $timeOut The timeout in seconds for the request.
     */
    public function openConnection($url, $method, $body, array $headers, int $timeOut)
    {
        $options = [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $this->makeCurlHeadersArray($headers),
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => $timeOut,
            CURLOPT_RETURNTRANSFER => true, // Return response as string
            CURLOPT_HEADER => true, // Enable header processing
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            //CURLOPT_CAINFO => __DIR__ . '/certs/RootCA.pem',
        ];

        if ($method !== "GET") {
            $options[CURLOPT_POSTFIELDS] = $body;
        }

        $this->curlService->init();
        $this->curlService->setoptArray($options);
    }


    /**
     * Make a curl-friendly array of headers.
     *
     * @param array $headers The request headers.
     * @return array
     */
    public function makeCurlHeadersArray(array $headers)
    {
        $return = [];

        foreach ($headers as $key => $value) {
            $return[] = $key . ': ' . $value;
        }

        return $return;
    }


    /**
     * Send the request
     */
    public function executeRequest()
    {
        $this->response = $this->curlService->exec();
    }

    /**
     * Closes an existing curl connection
     */
    public function closeConnection()
    {
        $this->curlService->close();
    }

    /**
     * Extracts the headers and the body into a two-part array
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