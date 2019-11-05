<?php


namespace Nurkassa;


use Nurkassa\Http\NurkassaRequest;
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
     * NurkassaClient constructor.
     * @param NurkassaHttpClientInterface|null $client
     */
    public function __construct(NurkassaHttpClientInterface $client = null)
    {
        $this->httpClient = $client;
    }

    public function requestExampleTemporary()
    {
        $url = $this->makeValidUrl('/company/cashiers/9542');

        $body = [
            'name' => 'Новое имя',
            'phone_number' => '+775411221122',
            'poses' => [
                1742, 1743, 1739
            ],
        ];

        return $this->httpClient->send(new NurkassaRequest('put', $url, $body, ['Authorization' => 'Bearer h2rOjGoWhofLZHLO9K0xW3h8Pyfml7RG7ikLXSemHNhmaSgBrgDXNu5NMNs6']));
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