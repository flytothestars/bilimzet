<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Helper\ApiResponseHelper;
use App\Helper\Helper;

class NewsController extends Controller
{
    public function list()
    {
        $items = News::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item->miniature = Helper::getUrl($item);
            $item->plain_text = strip_tags($item->text);
            $item->plain_text_kz = strip_tags($item->text_kz);
            return $item;
        });

        return ApiResponseHelper::success($items);
    }

    public function detail($id)
    {
        $item = News::find($id);
        if($item){
            $item->miniature = Helper::getUrl($item);
            $item->plain_text = strip_tags($item->text);
            $item->plain_text_kz = strip_tags($item->text_kz);
        }
        return ApiResponseHelper::success($item);
    }

    public function sbp()
    {

        $orderid = "98765";
        $amount = "200.00";
        $dt = '2024-12-19 11:14:42';
        $secret = "K5a8F1rxGJCis60upTi597oI1"; 

        $control = md5($orderid . $amount . $dt . $secret);

        $description = "Описание платежа";
        $redirect_url = "https://www.google.com";
        $account = "user_account_id";
        $merchant_site = "http://www.youtube.com";
        // dd($dt . '  ' . $control);
        $data = [
            'orderid' => $orderid,
            'amount' => $amount,
            'dt' => $dt,
            'control' => $control,
            'description' => $description,
            'redirect_url' => $redirect_url,
            'account' => $account,
            'merchant_site' => $merchant_site,
        ];

        $url = 'https://sredapay.kz/sbp-qr/partner/3107/pay?orderid='.$orderid.'&dt='.$dt.'&description=Optional description&amount='.$amount.'&control='.$control.'&redirect_url=https://ticketon.kz&account=123456789&merchant_site=https://ticketon.kz';
        // dd($url);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        if ($response) {
            $xml = simplexml_load_string($response);
            if ($xml) {
                $response_array = json_decode(json_encode($xml), true);
                
                if ($response_array['result'] == '1') {
                    echo "Ошибка: " . $response_array['descr'];
                } else {
                    echo "QR-код: " . $response_array['qr_code'];
                }
            } else {
                echo "Ошибка XML ответа.";
            }
        } else {
            echo "Ошибка запроса.";
        }

    }
}
