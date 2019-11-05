<?php

namespace Nurkassa\HttpClients;

use Nurkassa\Http\NurkassaRequest;

interface NurkassaHttpClientInterface
{
    public function send(NurkassaRequest $request);
}
