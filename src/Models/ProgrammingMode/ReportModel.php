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
     * @param integer $posShiftID ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function ZXReport($posShiftID): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/zxreport');
        return $this->last_request;
    }

    /**
     * Display a report by cashiers.
     * Показывает отчет по кассирам.
     *
     * @param integer $posShiftID  ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function cashiers($posShiftID)
    {
        $this->last_request = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/cashiers');
        return $this->last_request;
    }

    /**
     * Display a report by checks.
     * Показывает отчет по чекам.
     *
     * @param integer $posShiftID  ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function checks($posShiftID)
    {
        $this->last_request = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/checks');
        return $this->last_request;
    }

    /**
     * Display a report by sections.
     * Показывает отчет по секциям.
     *
     * @param integer $posShiftID  ID of the POS Shift
     *
     * @return NurkassaRequest
     */
    public function sections($posShiftID)
    {
        $this->last_request = new NurkassaRequest('get', '/company/pos/shifts/'.$posShiftID.'/sections');
        return $this->last_request;
    }
}
