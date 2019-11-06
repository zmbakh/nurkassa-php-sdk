<?php

namespace Nurkassa\Models\Pos;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class Pos extends Model
{
    /**
     * Display if purchase mode of the POS is on.
     * Показать включен ли режим покупки у кассы.
     *
     * @param $id
     *
     * @return NurkassaRequest
     */
    public function getPurchaseMode($id): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', 'pos/'.$id.'/purchase-mode');

        return $this->last_request;
    }
}
