<?php


namespace Nurkassa\HttpClients;


interface NurkassaHttpClientInterface
{
    /**
     * Send a request to the Nurkassa server
     * and return the response
     *
     * @return mixed
     */
    public function get();

    public function post();

    public function put();

    public function delete();
}