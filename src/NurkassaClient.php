<?php


namespace Nurkassa;


use Nurkassa\HttpClients\NurkassaHttpClientInterface;

class NurkassaClient
{
    /**
     * @const string The base API URL
     */
    //Todo change to production URL before publish
    const BASE_API_URL = 'http://nurkassa.web/api/v1/';

    /**
     * @const string The root URL of the website
     */
    const BASE_ROOT_URL = 'https://nurkassa.kz/';

    /**
     * @var NurkassaHttpClientInterface
     */
    protected $httpClient;

    /**
     * @var array Common headers for requests
     */
    protected $commonHeaders;


    /**
     * NurkassaClient constructor.
     * @param NurkassaHttpClientInterface|null $client
     */
    public function __construct(NurkassaHttpClientInterface $client = null)
    {
        $this->httpClient = $client;

        $this->prepareCommonHeaders();
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

        $this->commonHeaders = [
            'Accept' => 'application/json',
            'Accept-Charset' => 'utf-8',
            'User-Agent' => 'Nurkassa PHP SDK ' . Nurkassa::CURRENT_SDK_VERSION,
            'Referer' => $url,
        ];
    }


    /**
     * @param $url
     * @return string
     */
    protected function makeValidUrl($url)
    {
        if(strtolower(substr($url,0,4)) !==  'http') {
            if($url[0] === '/') {
                $url = mb_substr($url, 1);
            }

            $url = NurkassaClient::BASE_API_URL . $url;
        }

        return $url;
    }
}