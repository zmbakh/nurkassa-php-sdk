<?php

namespace Nurkassa\Models\Pos;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class PosModel extends Model
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
        $this->lastRequest = new NurkassaRequest('get', 'pos/'.$id.'/purchase-mode');

        return $this->lastRequest;
    }
}
