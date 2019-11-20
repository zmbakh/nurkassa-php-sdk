<?php

namespace Nurkassa\App;

use Nurkassa\Http\NurkassaRequest;

abstract class Model
{
    /**
     * @var NurkassaRequest the last prepared request
     */
    protected $lastRequest;

    /**
     * @return NurkassaRequest
     */
    public function __invoke(): NurkassaRequest
    {
        return $this->lastRequest;
    }

    /**
     * @return NurkassaRequest
     */
    public function getLastRequest(): NurkassaRequest
    {
        return $this->lastRequest;
    }
}
