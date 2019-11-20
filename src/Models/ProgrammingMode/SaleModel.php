<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class SaleModel extends Model
{
    /**
     * Show the sale info.
     * Показать данные о чеке.
     *
     * @param int $id
     *
     * @return NurkassaRequest
     */
    public function show(int $id): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/sales/'.$id);

        return $this->lastRequest;
    }
}
