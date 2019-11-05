<?php

namespace Nurkassa\Http;

use Nurkassa\Http\Body\RequestBodyMultipart;
use Nurkassa\Http\Body\RequestBodyUrlEncoded;
use Nurkassa\Nurkassa;

class NurkassaRequest
{
    /**
     * @var string Endpoint URL
     */
    protected $url;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array Headers of the request
     */
    protected $headers = [];

    /**
     * @var array The files to send with this request.
     */
    protected $files = [];

    /**
     * @var array params
     */
    protected $params = [];

    /**
     * @var array body of the request
     */
    protected $body;

    /**
     * @var int timeout to wait for response
     */
    protected $timeout = 60;

    /**
     * NurkassaRequest constructor.
     * @param string $method
     * @param string $url
     * @param array|null $body
     * @param array|null $headers
     * @param int|null $timeout
     */
    public function __construct(string $method, string $url, array $body = null, array $headers = null, int $timeout = null)
    {
        $this->prepareCommonHeaders();

        $this->method = strtoupper($method);
        $this->url = $url;

        if ($body) {
            $this->params = $body;
        }

        if ($headers) {
            $this->addHeaders($headers);
        }

        if ($timeout) {
            $this->timeout = $timeout;
        }
    }

    /**
     * Set common headers
     *
     * @return void
     */
    protected function prepareCommonHeaders()
    {
        $protocol = $_SERVER['HTTPS'] === 'on' ? 'https://' :'http://';
        $hostName = $_SERVER['HTTP_HOST'];
        $url = $protocol . $hostName;

        $this->headers = [
            'Accept' => 'application/json',
            'Accept-Charset' => 'utf-8',
            'User-Agent' => 'Nurkassa PHP SDK ' . Nurkassa::CURRENT_SDK_VERSION,
            'Referer' => $url,
        ];
    }

    /**
     * @param string $url
     * @return NurkassaRequest
     */
    public function setUrl(string $url): NurkassaRequest
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param array $headers
     * @return NurkassaRequest
     */
    public function setHeaders(array $headers): NurkassaRequest
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param array $headers
     * @return NurkassaRequest
     */
    public function addHeaders(array $headers): NurkassaRequest
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        if ($this->hasFiles()) {
            $this->setBodyMultipart();
            $header = ['Content-Type' => 'multipart/form-data; boundary=' . $this->body->getBoundary()];
        } else {
            $header = ['Content-Type' => 'application/x-www-form-urlencoded'];
        }

        return array_merge($this->headers, $header);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        if ($this->hasFiles()) {
            $this->setBodyMultipart();
        } else {
            $this->setBodyUrlEncoded();
        }

        return $this->body->getBody();
    }

    /**
     * @param array $params
     * @return NurkassaRequest
     */
    public function setParams(array $params): NurkassaRequest
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        $params = $this->params;

        if (in_array($this->method, ['PUT', 'DELETE'])) {
            $params = array_merge($params, ['_method' => $this->method]);
        }

        return $params;
    }

    /**
     * @param int $timeout
     * @return NurkassaRequest
     */
    public function setTimeout(int $timeout): NurkassaRequest
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @return void
     */
    public function setBodyUrlEncoded()
    {
        $params = $this->getParams();

        $this->body = new RequestBodyUrlEncoded($params);
    }

    /**
     * @return void
     */
    public function setBodyMultipart()
    {
        $params = $this->getParams();

        if (!$this->body instanceof RequestBodyMultipart){
            $this->body = new RequestBodyMultipart($params);
        }
    }

    /**
     * Checks if has files to upload
     *
     * @return bool
     */
    public function hasFiles() : bool
    {
        return !empty($this->files);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        if ($this->method == 'GET') {
            return $this->method;
        }

        return 'POST';
    }
}