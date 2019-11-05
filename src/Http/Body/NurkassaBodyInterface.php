<?php

namespace Nurkassa\Http\Body;

interface NurkassaBodyInterface
{
    /**
     * Get body to set in the request.
     *
     * @return mixed
     */
    public function getBody();
}
