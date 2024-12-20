<?php

namespace App\Services\Pay;

use Paybox\Pay\Facade as Paybox;

class PayboxService 
{


    const MERCHANT = '524685';
    const SECRET = 'oYhRW2DCMYnz5CbD'; //uwx6njhXevvcemMN


    public function init($price, $name, $course_id, $part_id){
        $user = auth()->user();
        $url = 'https://api.freedompay.kz/init_payment.php';
        $request = $requestForSignature = [
            'pg_order_id' => '25',
            'pg_merchant_id'=> self::MERCHANT,
            'pg_amount' => $price,
            'pg_description' => $name,
            'pg_salt' => 'molbulak',
            'pg_payment_route' => 'frame',
            'pg_currency' => 'KZT',
            'pg_language' => 'ru',
            // 'pg_success_url' => url('/success/pay/'. $user->id . '/' . $course_id . '/' . $part_id),
            'pg_success_url' => 'https://testbilimzet.kz/',
            'pg_failure_url' => 'https://testbilimzet.kz/courses',
            'pg_testing_mode' => '1',
            'pg_user_id' => '25095',
        ];    
        $requestForSignature = $this->makeFlatParamsArray($requestForSignature);

        ksort($requestForSignature); // Сортировка по ключю
        array_unshift($requestForSignature, 'init_payment.php'); // Добавление в начало имени скрипта
        array_push($requestForSignature, self::SECRET); // Добавление в конец секретного ключа

        $request['pg_sig'] = md5(implode(';', $requestForSignature)); // Полученная подпись
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        $response = curl_exec($ch);
        curl_close($ch);

        $xml = new \SimpleXMLElement($response);

        // Извлекаем нужные данные
        $result['pg_payment_id'] = (string) $xml->pg_payment_id;
        $result['pg_redirect_url'] = (string) $xml->pg_redirect_url;

        return $result;
    }

    public function makeFlatParamsArray($arrParams, $parent_name = '')
    {
        $arrFlatParams = [];
        $i = 0;
        foreach ($arrParams as $key => $val) {
            $i++;
            $name = $parent_name . $key . sprintf('%03d', $i);
            if (is_array($val)) {
                $arrFlatParams = array_merge($arrFlatParams, $this->makeFlatParamsArray($val, $name));
                continue;
            }
            $arrFlatParams += array($name => (string)$val);
        }

        return $arrFlatParams;
    }


}