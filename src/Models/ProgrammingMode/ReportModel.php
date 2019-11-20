<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class ReportModel extends Model
{
    /**
     * Display a Z/X Report.
     * Показывает Z/X отчет.
     *
     * @param int $posShiftID ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function ZXReport($posShiftID): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/zxreport');

        return $this->lastRequest;
    }

    /**
     * Display a report by cashiers.
     * Показывает отчет по кассирам.
     *
     * @param int $posShiftID ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function cashiers($posShiftID)
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/cashiers');

        return $this->lastRequest;
    }

    /**
     * Display a report by checks.
     * Показывает отчет по чекам.
     *
     * @param int $posShiftID ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function checks($posShiftID)
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/checks');

        return $this->lastRequest;
    }

    /**
     * Display a report by sections.
     * Показывает отчет по секциям.
     *
     * @param int $posShiftID ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function sections($posShiftID)
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/sections');

        return $this->lastRequest;
    }
}
