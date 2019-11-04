<?php

namespace Nurkassa\Http;

class NurkassaResponse
{
    /**
     * @var array The response headers.
     */
    protected $headers;

    /**
     * @var array The response body.
     */
    protected $body;

    /**
     * @var int The HTTP status response code.
     */
    protected $statusCode;

    /**
     * NurkassaResponse constructor.
     *
     * @param $headers
     * @param $body
     * @param null $statusCode
     */
    public function __construct($headers, $body, $statusCode = null)
    {
        if (is_numeric($statusCode)) {
            $this->statusCode = (int) $statusCode;
        }

        $this->body = $body;

        if (is_array($headers)) {
            $this->headers = $headers;
        } else {
            $this->makeArrayOfHeaders($headers);
        }
    }

    /**
     * Parse the raw headers and set as an array.
     *
     * @param string $headers The raw headers from the response.
     */
    protected function makeArrayOfHeaders($headers)
    {
        // Normalize line breaks
        $headers = str_replace("\r\n", "\n", $headers);

        // There will be multiple headers if a 301 was followed
        // or a proxy was followed, etc
        $headerCollection = explode("\n\n", trim($headers));
        // We just want the last response (at the end)
        $rawHeader = array_pop($headerCollection);

        $headerComponents = explode("\n", $rawHeader);
        foreach ($headerComponents as $line) {
            if (strpos($line, ': ') === false) {
                $this->getStatusCodeFromHeader($line);
            } else {
                list($key, $value) = explode(': ', $line, 2);
                $this->headers[$key] = $value;
            }
        }
    }

    /**
     * Sets the HTTP response code from the headers.
     *
     * @param string $headers
     */
    public function getStatusCodeFromHeader($headers)
    {
        list($version, $status, $reason) = array_pad(explode(' ', $headers, 3), 3, null);
        $this->statusCode = (int) $status;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

}