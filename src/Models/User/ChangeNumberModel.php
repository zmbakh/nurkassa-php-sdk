<?php

namespace Nurkassa\Models\User;

use Nurkassa\App\Model;
use Nurkassa\Http\NurkassaRequest;

class ChangeNumberModel extends Model
{
    /**
     * The first step of the number changing. Sending SMS.
     * Первый шаг смены номер. Отправка СМС.
     *
     * @param $phoneNumber
     *
     * @return NurkassaRequest
     */
    public function sendSMS($phoneNumber): NurkassaRequest
    {
        $data['phone_number'] = $phoneNumber;

        $this->lastRequest = new NurkassaRequest('post', 'change-number/send-sms', $data);

        return $this->lastRequest;
    }

    /**
     * The second and final step. Confirmation of the SMS code.
     * Второй и заключающий шаг. Подтверждение СМС кода.
     *
     * @param $phoneNumber
     * @param $smsCode
     *
     * @return NurkassaRequest
     */
    public function confirmSMS($phoneNumber, $smsCode): NurkassaRequest
    {
        $data['phone_number'] = $phoneNumber;
        $data['sms_code'] = $smsCode;

        $this->lastRequest = new NurkassaRequest('post', 'change-number/confirm-sms', $data);

        return $this->lastRequest;
    }
}
