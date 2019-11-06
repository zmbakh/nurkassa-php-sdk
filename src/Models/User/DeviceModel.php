<?php

namespace Nurkassa\Models\User;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class DeviceModel extends Model
{
    /**
     * Store a device of the user.
     * Сохранить устройство пользователя.
     *
     * @param string $uuid
     * @param string $model
     * @param string $platform
     * @param string $version
     * @param string $push_token
     *
     * @return NurkassaRequest
     */
    public function store(string $uuid, string $model, string $platform, string $version, string $push_token): NurkassaRequest
    {
        $data = compact('uuid', 'model', 'platform', 'version', 'push_token');
        $this->last_request = new NurkassaRequest('post', '/user/devices', $data);

        return $this->last_request;
    }
}
