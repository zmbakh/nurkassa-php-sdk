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
        $this->last_request = new NurkassaRequest('get', '/company/rates');
        return $this->last_request;
    }
}
