<?php

namespace Nurkassa\Authentication;

use Nurkassa\Http\NurkassaRequest;
use Nurkassa\Http\NurkassaResponse;

class AuthenticationService
{
    /**
     * Generates a request to send.
     *
     * @param string $phoneNumber
     * @param string $password
     *
     * @return NurkassaRequest
     */
    public static function request(string $phoneNumber, string $password): NurkassaRequest
    {
        return new NurkassaRequest('post', 'login', ['phone_number' => $phoneNumber, 'password' => $password]);
    }

    /**
     * Get access token from the response.
     *
     * @param NurkassaResponse $response
     *
     * @return string|null
     */
    public static function getAccessToken(NurkassaResponse $response)
    {
        $body = $response->getBody();

        if (isset($body['data']['api_token'])) {
            return $body['data']['api_token'] ?: null;
        }
    }

    /**
     * Checks for errors in the response.
     *
     * @param NurkassaResponse $response
     *
     * @return array|null
     */
    public static function checkForErrors(NurkassaResponse $response)
    {
        if ($response->getStatusCode() != 200) {
            $data['status_code'] = $response->getStatusCode();

            $body = $response->getBody();

            if (isset($body['errors'])) {
                $data['errors'] = $body['errors'];
            }

            return $data;
        }
    }
}
