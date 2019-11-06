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
        $this->last_request = new NurkassaRequest('get', '/company/cashiers');

        return $this->last_request;
    }

    /**
     * Store a new cashier.
     * Сохранить нового кассира.
     *
     * @param string $name
     * @param string $phone_number
     * @param string $password
     * @param array  $poses
     *
     * @return NurkassaRequest
     */
    public function store(string $name, string $phone_number, string $password, array $poses): NurkassaRequest
    {
        $data = [
            'name'         => $name,
            'phone_number' => $phone_number,
            'password'     => $password,
            'poses'        => $poses,
        ];

        $this->last_request = new NurkassaRequest('post', '/company/cashiers', $data);

        return $this->last_request;
    }

    /**
     * Update the cashier's info
     * Обновить данные кассира.
     *
     * @param int   $id
     * @param array $attributes See the API documentation for more info.
     *
     * @return NurkassaRequest
     */
    public function update($id, $attributes): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('put', '/company/cashiers/'.$id, $attributes);

        return $this->last_request;
    }

    /**
     * Display the trashed cashiers list of the company.
     * Показывает список кассиров компании, которые были удалены.
     *
     * @return NurkassaRequest
     */
    public function trashed(): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', '/company/cashiers/trashed');

        return $this->last_request;
    }
}
