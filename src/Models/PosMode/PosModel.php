<?php

namespace Nurkassa\Models\PosMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class PosModel extends Model
{
    /**
     * Display the POS.
     * Показать информацию о кассе.
     *
     * @param int $posID
     *
     * @return NurkassaRequest
     */
    public function show(int $posID): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', 'pos/'.$posID.'/show', null, ['Pos-Id' => $posID]);
        return $this->last_request;
    }

    /**
     * Display check.
     * Показать чек.
     *
     * @param int $posID
     * @param int $saleID
     * @return NurkassaRequest
     */
    public function sale(int $posID, int $saleID): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', 'pos/'.$saleID.'/sale', null, ['Pos-Id' => $posID]);
        return $this->last_request;
    }

    /**
     * Show operations of the shift.
     * Показать все операции за смену.
     *
     * @param int $posID
     * @param int $page
     *
     * @return NurkassaRequest
     */
    public function sales(int $posID, int $page = 1): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', 'pos/sales', compact('page'), ['Pos-Id' => $posID]);
        return $this->last_request;
    }

    /**
     * X Report.
     * X отчет.
     *
     * @param int $posID
     *
     * @return NurkassaRequest
     */
    public function report(int $posID): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', 'pos/report', null, ['Pos-Id' => $posID]);
        return $this->last_request;
    }

    /**
     * Cash deposit or withdrawal.
     * Внесение либо изъятие денежных средств.
     *
     * @param int $posID
     * @param float $sum
     * @param string $date
     * @param int $type
     *
     * @return NurkassaRequest
     */
    public function replacement(int $posID, float $sum, string $date, int $type): NurkassaRequest
    {
        $data = compact('sum', 'date', 'type');
        $this->last_request = new NurkassaRequest('post', 'money/placement', $data, ['Pos-Id' => $posID]);
        return $this->last_request;
    }

    /**
     * Handle sale operation.
     * Выполнить операцию продажи/покупки/возврат.
     *
     * @param int $posID
     * @param int $status
     * @param array $goods
     * @param array $payment
     *
     * @return NurkassaRequest
     */
    public function handleSale(int $posID, int $status, array $goods, array $payment): NurkassaRequest
    {
        $data = compact('status', 'goods', 'payment');
        $this->last_request = new NurkassaRequest('post', 'money/placement', $data, ['Pos-Id' => $posID]);
        return $this->last_request;
    }
}