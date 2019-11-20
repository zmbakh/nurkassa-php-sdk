<?php

namespace Nurkassa\Models\Information;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class LatestVersionModel extends Model
{
    /**
     * Display the latest version of iOS.
     * Показать последнюю версию iOS.
     *
     * @return NurkassaRequest
     */
    public function iOS(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', 'latest-version/ios');

        return $this->lastRequest;
    }

    /**
     * Display the latest version of Android.
     * Показать последнюю версию Android.
     *
     * @return NurkassaRequest
     */
    public function android(): NurkassaRequest
    {
        $this->lastRequest = new NurkassaRequest('get', 'latest-version/android');

        return $this->lastRequest;
    }
}
