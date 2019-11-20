<?php

namespace Nurkassa\Models\PosMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class PosShiftModel extends Model
{
    /**
     * Display the info of the POS Shift.
     * Показать информацию о смене.
     *
     * @param int $posID
     * @param int $shiftID
     *
     * @return NurkassaRequest
     */
    public function show(int $posID, int $shiftID): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', 'pos/shift/'.$shiftID, null, ['Pos-Id' => $posID]);

        return $this->lastRequest;
    }

    /**
     * Close the active shift.
     * Закрыть активную смену.
     *
     * @param int $posID
     *
     * @return NurkassaRequest
     */
    public function close(int $posID): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('post', 'close/shift', null, ['Pos-Id' => $posID]);

        return $this->lastRequest;
    }
}
