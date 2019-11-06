<?php

namespace Nurkassa\Models\PosMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class SaleSectionModel extends Model
{
    /**
     * Display the sale sections of the company.
     * Показывает список отделов продаж компании.
     *
     * @return NurkassaRequest
     */
    public function index(): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', '/sections');
        return $this->last_request;
    }
}
