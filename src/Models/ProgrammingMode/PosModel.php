<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class PosModel extends Model
{
    /**
     * Get the POSes of the user's company.
     * Получение списка касс компании пользователя.
     *
     * @return NurkassaRequest
     */
    public function index(): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', '/company/pos');

        return $this->last_request;
    }

    /**
     * Store a new POS of the user's company.
     * Сохранит новую кассу для компании пользователя.
     *
     * @param string $name        Name of the POS
     * @param int    $salePointId The ID of one of the sale points of the user's company
     * @param string $timeZone    By the time of writing the SDK, only 'Asia/Almaty' and 'Asia/Aqtau' are available
     *
     * @return NurkassaRequest
     */
    public function store(string $name, int $salePointId, string $timeZone): NurkassaRequest
    {
        $data = [
            'name'          => $name,
            'sale_point_id' => $salePointId,
            'time_zone'     => $timeZone,
        ];

        $this->last_request = new NurkassaRequest('post', '/company/pos', $data);

        return $this->last_request;
    }

    /**
     * Update information of the POS.
     * Редактировать кассу.
     *
     * @param int   $id
     * @param array $attributes Associative array of data. See API documentation for more info
     *                          Editable params by the time of writing the SDK:
     *                          'name', 'address', 'time_zone', 'purchase_mode', 'is_auto_close', 'auto_close_time',
     *                          'email', 'kkm_id', 'registration_number', 'is_withdraw_money', 'sale_point_id',
     *                          'advert'.
     *
     * @return NurkassaRequest
     */
    public function update(int $id, array $attributes): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('put', '/company/pos/'.$id, $attributes);

        return $this->last_request;
    }

    /**
     * Get the shifts of the POS.
     *
     * @param int    $id
     * @param string $dateFrom Show shifts from the date YYYY-mm-dd (including)
     * @param string $dateTo   Show shifts to the date YYYY-mm-dd (including)
     *
     * @return NurkassaRequest
     */
    public function shifts(int $id, string $dateFrom = null, string $dateTo = null):NurkassaRequest
    {
        $request = new NurkassaRequest('get', '/company/pos/'.$id.'/shifts');

        if ($dateFrom) {
            $request->addParams(['date_from' => $dateFrom]);
        }

        if ($dateTo) {
            $request->addParams(['date_to' => $dateTo]);
        }

        $this->last_request = $request;

        return $this->last_request;
    }
}
