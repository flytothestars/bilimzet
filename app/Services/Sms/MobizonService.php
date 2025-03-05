<?php

namespace App\Services\Sms;

use App\Models\VerifyPhone;
use Mobizon\MobizonApi;
use App\Helper\ApiResponseHelper;

class MobizonService {

    const TOKEN = 'kzec1be73ab08934718614228484ba0205b5992059599dce93edc7ee0e68b955b6fa37';

    const EXPIRED_MINUTE = 15;

    const TEST_NUMBER = '77756554054';

    const IS_PROD = true;

    public function send($phone)
    {
        $api = new MobizonApi(self::TOKEN, 'api.mobizon.kz');
        $code = $this->generate();
        $message = "Код подтверждение - $code Bilimzet.kz";
        if ($phone == self::TEST_NUMBER)
        {
            // $this->save($phone, $code);
            return true;
        }
        else if(self::IS_PROD){
            if ($api->call('message','sendSMSMessage',
                            array(
                                'recipient' => $phone,
                                'text' => $message,
                                'params[validity]' => 1440))) 
            {
                $this->save($phone, $code);
                return true;
            } else {
                return false;
                echo '[' . $api->getCode() . '] ' . $api->getMessage() . 'See details below:' . PHP_EOL . print_r($api->getData(), true) . PHP_EOL;
            }
        }
    }

    public function verify($phone, $code)
    {
        $verification = VerifyPhone::where('phone', $phone)
                               ->where('code', $code)
                               ->first();
        if (!$verification || $verification->expired_at < now()) {
            return false;
        }
        return true;
    }

    private function save($phone, $code)
    {
        VerifyPhone::updateOrCreate(
            ['phone' => $phone],
            [
                'code' => $code,
                'expired_at' => now()->addMinutes(self::EXPIRED_MINUTE)
            ]
        );
    }

    private function generate()
    {
        return rand(1000, 9999);;
    }

}
