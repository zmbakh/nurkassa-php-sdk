<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class CashierModel extends Model
{
    /**
     * Display the cashiers list of the company.
     * Показывает список кассиров компании.
     *
     * @return NurkassaRequest
     */
    public function index(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/cashiers');

        return $this->lastRequest;
    }

    /**
     * Store a new cashier.
     * Сохранить нового кассира.
     *
     * @param string $name
     * @param string $phoneNumber
     * @param string $password
     * @param array  $poses
     *
     * @return NurkassaRequest
     */
    public function store(string $name, string $phoneNumber, string $password, array $poses): NurkassaRequest
    {
        $data = [
            'name'         => $name,
            'phone_number' => $phoneNumber,
            'password'     => $password,
            'poses'        => $poses,
        ];

        $this->lastRequest = new NurkassaRequest('post', '/company/cashiers', $data);

        return $this->lastRequest;
    }

    /**
     * Update the cashier's info.
     * Обновить данные кассира.
     *
     * @param int   $id
     * @param array $attributes See the API documentation for more info.
     *
     * @return NurkassaRequest
     */
    public function update($id, $attributes): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('put', '/company/cashiers/'.$id, $attributes);

        return $this->lastRequest;
    }

    /**
     * Display the trashed cashiers list of the company.
     * Показывает список кассиров компании, которые были удалены.
     *
     * @return NurkassaRequest
     */
    public function trashed(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/cashiers/trashed');

        return $this->lastRequest;
    }
}
