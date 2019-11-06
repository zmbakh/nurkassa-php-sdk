<?php

namespace Nurkassa\Models\PosMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class ProductModel extends Model
{
    /**
     * Search product of the company.
     * Поиск продукта компании.
     *
     * @param string $searchKeyword
     *
     * @return NurkassaRequest
     */
    public function search(string $searchKeyword): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', '/products', ['q' => $searchKeyword]);

        return $this->last_request;
    }
}
