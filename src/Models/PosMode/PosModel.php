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
        $this->lastRequest = new NurkassaRequest('get', 'pos/'.$posID.'/show', null, ['Pos-Id' => $posID]);

        return $this->lastRequest;
    }

    /**
     * Display check.
     * Показать чек.
     *
     * @param int $posID
     * @param int $saleID
     *
     * @return NurkassaRequest
     */
    public function sale(int $posID, int $saleID): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', 'pos/'.$saleID.'/sale', null, ['Pos-Id' => $posID]);

        return $this->lastRequest;
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
        $this->lastRequest = new NurkassaRequest('get', 'pos/sales', compact('page'), ['Pos-Id' => $posID]);

        return $this->lastRequest;
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
        $this->lastRequest = new NurkassaRequest('get', 'pos/report', null, ['Pos-Id' => $posID]);

        return $this->lastRequest;
    }

    /**
     * Cash deposit or withdrawal.
     * Внесение либо изъятие денежных средств.
     *
     * @param int    $posID
     * @param float  $sum
     * @param string $date
     * @param int    $type
     *
     * @return NurkassaRequest
     */
    public function replacement(int $posID, float $sum, string $date, int $type): NurkassaRequest
    {
        $data = compact('sum', 'date', 'type');
        $this->lastRequest = new NurkassaRequest('post', 'money/placement', $data, ['Pos-Id' => $posID]);

        return $this->lastRequest;
    }

    /**
     * Handle sale operation.
     * Выполнить операцию продажи/покупки/возврат.
     *
     * @param int   $posID
     * @param int   $status
     * @param array $goods
     * @param array $payment
     * @param int   $qr
     *
     * @return NurkassaRequest
     */
    public function handleSale(int $posID, int $status, array $goods, array $payment, int $qr = null): NurkassaRequest
    {
        $data = compact('status', 'goods', 'payment');

        if ($qr) {
            $data = array_merge($data, ['qr' => $qr]);
        }

        $request = new NurkassaRequest('post', 'sale', $data, ['Pos-Id' => $posID]);
        $request->setVersion(2);

        $this->lastRequest = $request;

        return $this->lastRequest;
    }

    /**
     * Get the receipt of the sale.
     * Вывести чек от продажи.
     *
     * @param int $posID
     * @param int $saleID
     * @return NurkassaRequest
     */
    public function saleReceipt(int $posID, int $saleID): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', 'sale/'.$saleID.'/receipt', null, ['Pos-Id' => $posID]);
        $this->lastRequest->setVersion(2);

        return $this->lastRequest;
    }
}
