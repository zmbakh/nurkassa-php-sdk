<?php

namespace Nurkassa\HttpClients;

use Nurkassa\Exceptions\ResponseWithErrorException;
use Nurkassa\Http\NurkassaRequest;
use Nurkassa\Http\NurkassaResponse;

interface NurkassaHttpClientInterface
{
    /**
     * @param NurkassaRequest $request
     *
     * @throws ResponseWithErrorException
     *
     * @return NurkassaResponse
     */
    public function send(NurkassaRequest $request);
}
