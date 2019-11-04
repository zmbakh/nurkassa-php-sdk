<?php


namespace Nurkassa\HttpClients;


interface NurkassaHttpClientInterface
{
    /**
     * Send a get request to the Nurkassa server
     * and return the response
     *
     * @param $url
     * @param $headers
     * @return mixed
     */
    public function get(string $url, array $headers = []);

    /**
     * Send a post request
     *
     * @param $url
     * @param $body
     * @param $headers
     * @param bool $multipart
     * @return mixed
     */
    public function post(string $url, array $body, array $headers = [], bool $multipart = false);

    /**
     * Send a put request
     *
     * @param string $url
     * @param array $body
     * @param array $headers
     * @param bool $multipart
     * @return mixed
     */
    public function put(string $url, array $body, array $headers = [], bool $multipart = false);

    /**
     * Send a delete request
     *
     * @param string $url
     * @param array $headers
     * @return mixed
     */
    public function delete(string $url, array $headers = []);
}