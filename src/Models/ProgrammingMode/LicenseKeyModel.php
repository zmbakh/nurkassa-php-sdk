<?php

namespace Nurkassa\Models\ProgrammingMode;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class LicenseKeyModel extends Model
{
    /**
     * Display the purchased keys of the company.
     * Показать приобретенные ключи компании.
     *
     * @return NurkassaRequest
     */
    public function index(): NurkassaRequest
    {
        $this->last_request = new NurkassaRequest('get', '/company/license-keys');

        return $this->last_request;
    }

    /**
     * Activate the key to the POS.
     * Активировать ключ к кассе.
     *
     * @param int $key_id
     * @param int $pos_id
     *
     * @return NurkassaRequest
     */
    public function activate(int $key_id, int $pos_id): NurkassaRequest
    {
        $data = compact('key_id', 'pos_id');
        $this->last_request = new NurkassaRequest('post', '/company/license-keys/activate', $data);

        return $this->last_request;
    }

    /**
     * Buy a new key.
     * Купить ключ.
     *
     * @param int $rate_id
     *
     * @return NurkassaRequest
     */
    public function purchase(int $rate_id): NurkassaRequest
    {
        $data = compact('rate_id');
        $this->last_request = new NurkassaRequest('post', '/company/license-keys/purchase', $data);

        return $this->last_request;
    }
}
