<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class ProductModel extends Model
{
    /**
     * Display products of the company.
     * Показать продукты компании.
     *
     * @param int $page
     *
     * @return NurkassaRequest
     */
    public function index(int $page = 1): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/products', compact('page'));

        return $this->lastRequest;
    }

    /**
     * Show the product info.
     * Показать информацию о продукте.
     *
     * @param int $id
     *
     * @return NurkassaRequest
     */
    public function show(int $id): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/company/products/'.$id);

        return $this->lastRequest;
    }

    /**
     * Store new product.
     * Сохранить новый продукт.
     *
     * @param string $name
     * @param int    $barcode
     * @param float  $price
     * @param int    $discount
     * @param int    $markup
     *
     * @return NurkassaRequest
     */
    public function store(string $name, int $barcode, float $price, int $discount, int $markup): NurkassaRequest
    {
        $data = compact('name', 'barcode', 'discount', 'markup', 'price');
        $this->lastRequest = new NurkassaRequest('post', '/company/products', $data);

        return $this->lastRequest;
    }

    /**
     * Update info of the product.
     * Обновить данные продукта.
     *
     * @param int    $id
     * @param string $name
     * @param int    $barcode
     * @param float  $price
     * @param int    $discount
     * @param int    $markup
     *
     * @return NurkassaRequest
     */
    public function update(int $id, string $name, int $barcode, float $price, int $discount, int $markup): NurkassaRequest
    {
        $data = compact('name', 'barcode', 'discount', 'markup', 'price');

        $this->lastRequest = new NurkassaRequest('put', '/company/products/'.$id, $data);

        return $this->lastRequest;
    }

    /**
     * Delete the product.
     * Удалить продукт.
     *
     * @param int $id
     *
     * @return NurkassaRequest
     */
    public function delete(int $id)
    {
        $this->lastRequest = new NurkassaRequest('delete', '/company/products/'.$id);

        return $this->lastRequest;
    }
}
