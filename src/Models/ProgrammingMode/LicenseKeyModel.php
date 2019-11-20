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
        $this->lastRequest = new NurkassaRequest('get', '/company/license-keys');

        return $this->lastRequest;
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
        $this->lastRequest = new NurkassaRequest('post', '/company/license-keys/activate', $data);

        return $this->lastRequest;
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
        $this->lastRequest = new NurkassaRequest('post', '/company/license-keys/purchase', $data);

        return $this->lastRequest;
    }
}
