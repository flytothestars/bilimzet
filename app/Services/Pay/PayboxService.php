<?php

namespace App\Services\Pay;

use Paybox\Pay\Facade as Paybox;
use App\Models\CourseBuy;

class PayboxService 
{


    const MERCHANT = '524685';
    const SECRET = 'oYhRW2DCMYnz5CbD'; //uwx6njhXevvcemMN


    public function init($course, $part, $request){
        $user = auth()->user();
        $orderId = $course->id.'-'.$part->id.'-'.$user->id.'-'.rand(000000,999999);
        $courseBuy = CourseBuy::where('course_id', $course->id)->where('course_part_id', $part->id)->where('user_id', $user->id)->first();
        if($courseBuy){
            return false;
        }
        $url = 'https://api.freedompay.kz/init_payment.php';
        $request = $requestForSignature = [
            'pg_order_id' => $orderId,
            'pg_merchant_id'=> self::MERCHANT,
            'pg_amount' => $part->price_kzt,
            'pg_description' => $course->title,
            'pg_salt' => 'molbulak',
            'pg_payment_route' => 'frame',
            'pg_currency' => 'KZT',
            'pg_language' => 'ru',
            'pg_result_url' => route('course.result.buy'),
            'pg_success_url' => $request->success_url,
            'pg_success_url_method' => 'GET',
            'pg_failure_url' => $request->failure_url,
            'pg_testing_mode' => '0',
            'pg_user_id' => auth()->user()->id,
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