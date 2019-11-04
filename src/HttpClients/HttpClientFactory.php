<?php

namespace Nurkassa\HttpClients;

use Exception;
use GuzzleHttp\Client;
use InvalidArgumentException;

class HttpClientFactory
{
    /**
     * Return Http Client Handler.
     *
     * @param $client
     *
     * @throws Exception
     *
     * @return NurkassaCurlHttpClient|NurkassaGuzzleHttpClient|Client
     */
    public static function createHttpClient($client)
    {
        if (!$client) {
            return self::defaultHttpClient();
        }

        if (is_string($client)) {
            return self::handleStringArgument($client);
        }

        return self::handleClient($client);
    }

    /**
     * Handles client if the argument is string.
     *
     * @param $client
     *
     * @throws Exception
     *
     * @return NurkassaCurlHttpClient|NurkassaGuzzleHttpClient|void
     */
    protected static function handleStringArgument($client)
    {
        if ('curl' === $client) {
            if (!extension_loaded('curl')) {
                throw new Exception('The cURL extension must be loaded in order to use the "curl" handler.');
            }

            return new NurkassaCurlHttpClient();
        }

        if ('guzzle' === $client) {
            if (!class_exists('GuzzleHttp\Client')) {
                throw new Exception('The Guzzle HTTP client must be included in order to use the "guzzle" handler.');
            }

            return new NurkassaGuzzleHttpClient();
        }

        throw new InvalidArgumentException('The http client handler must be "curl" or "guzzle".');
    }

    /**
     * Return client.
     *
     * @param $client
     *
     * @return mixed
     */
    protected static function handleClient($client)
    {
        if ($client instanceof NurkassaHttpClientInterface) {
            return $client;
        }

        if ($client instanceof NurkassaCurlHttpClient) {
            return $client;
        }

        if ($client instanceof Client) {
            return new NurkassaGuzzleHttpClient($client);
        }

        throw new InvalidArgumentException('The http client handler must be implementation of HttpClients\NurkassaHttpClientInterface or instance of GuzzleHttp\Client.');
    }


    /**
     * Set default client.
     *
     * @return NurkassaCurlHttpClient|NurkassaGuzzleHttpClient
     */
    protected static function defaultHttpClient()
    {

        if (extension_loaded('curl')) {
            return new NurkassaCurlHttpClient();
        }

        if (class_exists('GuzzleHttp\Client')) {
            return new NurkassaGuzzleHttpClient();
        }

        throw new InvalidArgumentException('The SDK requires CUrl or Guzzle.');
    }

}