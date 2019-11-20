<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class SaleSectionModel extends Model
{
    /**
     * Display sale sections of the company.
     * Показать отделы продаж компании.
     *
     * @return NurkassaRequest
     */
    public function index(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/sale-sections');

        return $this->lastRequest;
    }

    /**
     * Show the sale section info.
     * Показать данные отдела продаж.
     *
     * @param int $id
     *
     * @return NurkassaRequest
     */
    public function show(int $id): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/sale-sections/'.$id);

        return $this->lastRequest;
    }

    /**
     * Store new sale section.
     * Сохранить новый отдел продаж.
     *
     * @param $title
     *
     * @return NurkassaRequest
     */
    public function store(string $title): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('post', '/company/sale-sections', compact('title'));

        return $this->lastRequest;
    }

    /**
     * Update info of the sale section.
     * Обновить данные отдела продаж.
     *
     * @param int    $id
     * @param string $title
     *
     * @return NurkassaRequest
     */
    public function update(int $id, string $title): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('put', '/company/sale-sections/'.$id, compact('title'));

        return $this->lastRequest;
    }

    /**
     * Delete the sale section.
     * Удалить отдел продаж.
     *
     * @param int $id
     *
     * @return NurkassaRequest
     */
    public function delete(int $id)
    {
        $this->lastRequest = new NurkassaRequest('delete', '/company/sale-sections/'.$id);

        return $this->lastRequest;
    }
}
