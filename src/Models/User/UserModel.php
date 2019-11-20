<?php

namespace Nurkassa\Models\User;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class UserModel extends Model
{
    /**
     * Display info about the user.
     * Показать информацию о текущем пользователе.
     *
     * @return NurkassaRequest
     */
    public function profile(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', '/user');

        return $this->lastRequest;
    }
}
