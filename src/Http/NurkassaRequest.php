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
     * @var int Version of the endpoint
     */
    protected $version = 1;

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
     * @var RequestBodyMultipart|RequestBodyUrlEncoded body of the request
     */
    protected $body;

    /**
     * @var int timeout to wait for response
     */
    protected $timeout = 60;

    /**
     * NurkassaRequest constructor.
     *
     * @param string     $method
     * @param string     $url
     * @param array|null $body
     * @param array|null $headers
     * @param int|null   $timeout
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
     * Set common headers.
     *
     * @return void
     */
    protected function prepareCommonHeaders()
    {
        if (isset($_SERVER['HTTPS'])) {
            $protocol = $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        } else {
            $protocol = null;
        }

        if (isset($_SERVER['HTTPS'])) {
            $hostName = $_SERVER['HTTP_HOST'];
        } else {
            $hostName = null;
        }

        $url = $protocol.$hostName;

        $this->headers = [
            'Accept'         => 'application/json',
            'Accept-Charset' => 'utf-8',
            'User-Agent'     => 'Nurkassa PHP SDK '.Nurkassa::CURRENT_SDK_VERSION,
            'Referer'        => $url,
        ];
    }

    /**
     * @param string $url
     *
     * @return NurkassaRequest
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        $url = $this->url;

        if ($this->getMethod() == 'GET') {
            $url = $this->appendParamsToUrl($url, $this->params);
        }

        return $url;
    }

    /**
     * @param array $headers
     *
     * @return NurkassaRequest
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return NurkassaRequest
     */
    public function addHeaders(array $headers): self
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
            $header = ['Content-Type' => 'multipart/form-data; boundary='.$this->body->getBoundary()];
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
     *
     * @return NurkassaRequest
     */
    public function setParams(array $params): self
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
     * @param array $params
     *
     * @return NurkassaRequest
     */
    public function addParams(array $params): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * @param int $timeout
     *
     * @return NurkassaRequest
     */
    public function setTimeout(int $timeout): self
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

        if (!$this->body instanceof RequestBodyMultipart) {
            $this->body = new RequestBodyMultipart($params);
        }
    }

    /**
     * Checks if has files to upload.
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

    /**
     * @param $url
     * @param array $newParams
     *
     * @return string
     */
    protected function appendParamsToUrl($url, array $newParams = [])
    {
        if (empty($newParams)) {
            return $url;
        }

        if (strpos($url, '?') === false) {
            return $url.'?'.http_build_query($newParams, null, '&');
        }

        list($path, $query) = explode('?', $url, 2);
        $existingParams = [];
        parse_str($query, $existingParams);

        // Favor params from the original URL over $newParams
        $newParams = array_merge($newParams, $existingParams);

        // Sort for a predicable order
        ksort($newParams);

        return $path.'?'.http_build_query($newParams, null, '&');
    }

    /**
     * @param int $version
     *
     * @return NurkassaRequest
     */
    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }
}
