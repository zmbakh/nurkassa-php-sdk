<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class SalePointModel extends Model
{
    /**
     * Display sale points of the company.
     * Показать точки продаж компании.
     *
     * @return NurkassaRequest
     */
    public function index(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/sale-points');

        return $this->lastRequest;
    }

    /**
     * Show the sale point info.
     * Показать информацию о точке продаж.
     *
     * @param int $id
     *
     * @return NurkassaRequest
     */
    public function show(int $id): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/sale-points/'.$id);

        return $this->lastRequest;
    }

    /**
     * Store new sale point.
     * Сохранить новую точку продаж.
     *
     * @param $title
     *
     * @return NurkassaRequest
     */
    public function store(string $title): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('post', '/company/sale-points', compact('title'));

        return $this->lastRequest;
    }

    /**
     * Update info of the sale point.
     * Обновить данные точки продаж.
     *
     * @param int    $id
     * @param string $title
     *
     * @return NurkassaRequest
     */
    public function update(int $id, string $title): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('put', '/company/sale-points/'.$id, compact('title'));

        return $this->lastRequest;
    }

    /**
     * Delete the sale point.
     * Удалить точку продаж.
     *
     * @param int $id
     *
     * @return NurkassaRequest
     */
    public function delete(int $id)
    {
        $this->lastRequest = new NurkassaRequest('delete', '/company/sale-points/'.$id);

        return $this->lastRequest;
    }
}
