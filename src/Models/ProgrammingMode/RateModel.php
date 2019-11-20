<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class RateModel extends Model
{
    /**
     * Show the rates list.
     * Список тарифов.
     *
     * @return NurkassaRequest
     */
    public function index(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/rates');

        return $this->lastRequest;
    }
}
