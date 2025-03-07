<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Helper\ApiResponseHelper;
use App\Models\Course;
use App\Models\LibraryItem;
use App\Helper\Helper;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class MainController extends Controller
{
    private mixed $config;

    public function __construct(){
        $this->config = config('payment.services.sbp.config');
    }
    
    public function feedback(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'name'  => 'nullable|string',
        ]);
        $feedback = FeedBack::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        if(!$feedback)
        {
            return ApiResponseHelper::error();
        }

        return ApiResponseHelper::success();
    }

    public function search(Request $request){
        $request->validate([
            'data'  => 'nullable|string',
        ]);
        $searchTerm = $request->data;
        $results = [];
        $resultsModelCourse = Course::where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('desc_text', 'LIKE', "%{$searchTerm}%")
            ->get(['id','title', 'desc_text'])
            ->map(function ($item) {

                return [
                    'type'          => 'course',
                    'title'         => $item->title,
                    'description'   => strip_tags($item->desc_text),
                    'url'           => url('api/course/'.$item->id),
                    'picture'       => url('images/icons/'.rand(1,50).'.png'),
                ];
            });
            
        // dd($resultsModelCourse);
        return ApiResponseHelper::success($resultsModelCourse);
    }

    public function searchArticle(Request $request){
        $request->validate([
            'data'  => 'nullable|string',
        ]);
        $searchTerm = $request->data;
        $results = [];
        $resultsModelArticle = LibraryItem::where('is_published', 1)
            ->where('title', 'LIKE', "%{$searchTerm}%")
            ->orderBy('created_at', 'DESC')
            ->get()->map(function($item){
                $item->author = User::where('id', $item->author_id)->get()->map(function($user){
                    $user->photo = Helper::getUrls($user, 'profilePhoto');
                    return $user;
                });
                $item->category = Category::find($item->category);
                $item->document = Helper::getUrls($item, 'articleDocument');
                $item->document_extension = Helper::getExtension($item, 'articleDocument');
                $item->document_extension = url('/images/extension/'.Helper::getExtension($item, 'articleDocument').'.png');                
                $item->plain_text = strip_tags($item->text);
                $item->plain_text_kz = strip_tags($item->text_kz);
                return $item;
        });
            
        // dd($resultsModelCourse);
        return ApiResponseHelper::success($resultsModelArticle);
    }

    public function sbp()
    {
        $url = $this->generate();
        // dd($url['link']);
        return [
            'url' => '',
            'paymentUrl' => $url['link'],
            'paymentUrlQr' => $url['qr'],
            'fields' => '',
        ];
    }

    public function generate()
    {
        $date = date('Y-m-d H:i:s');
        $invoiceId = rand(000000000,999999999);
        $amount = 500;
        $control = md5($invoiceId . $amount . $date . $this->config['secret_key']);
        Log::info('SSBPPaymentServiceBP generateQrCode данный ответ:' . json_encode($control));

        $data = [
            'orderid'       => $invoiceId,
            'amount'        => $amount,
            'dt'            => $date,
            'control'       => $control,
            'description'   => 'Покупка билета',
            'redirect_url'  => 'https://ticketon.kz/thank-you?sale=48507574&1ang=ru&token=76274b5a706729e846118c8f920ba9ddba4a6f29',
            'account'       => '3107',
            'merchant_site' => null,
        ];


        Log::info('SSBPPaymentServiceBP generateQrCode данные ответ:' . json_encode($data));
        Log::info('SSBPPaymentServiceBP generateQrCode данные ответ:' . json_encode($this->config['url_qr']));
        Log::info('SSBPPaymentServiceBP generateQrCode данные ответ:' . json_encode($this->config['secret_key']));
        try {
            $response = $this->makeRequest($data, $this->config['url_qr']);
            $redirectData = $this->getData($response);
            
            return $redirectData;
        } catch (Exception $e) {
            Log::error('sbp generate curl error ' . $e->getMessage());
        }
    }

    private function getData($data): array
    {
        $xml = simplexml_load_string($data);
        if ($xml === false) {
            throw new Exception('Ошибка при загрузке XML');
        }
        

        $result = [
            'qr' => null,
            'link' => null,
        ];
        
        foreach ($xml->data->entry as $entry) {
            $values = $entry->string;
        
            // qr
            if ((string)$values[0] === 'qrlink') {
                $result['qr'] = (string)$values[1];
            }
            
            // link
            if ((string)$values[0] === 'qrpayload') {
                $result['link'] = base64_decode((string)$values[1]);
            }
        }
        return $result;        
    }

    private function makeRequest($data, $url): string
    {
        $queryString = http_build_query($data);
        $fullUrl = $url . '?' . $queryString;

        Log::info('SSBPPaymentServiceBP makeRequest full url ответ:' . json_encode($fullUrl));

        $response = Http::timeout(30)
            ->post($fullUrl); 

        // Log::info('SSBPPaymentServiceBP makeRequest ответ:' . json_encode($response->body()));
        if ($response->failed()) {
            throw new Exception('HTTP request failed: ' . $response->body());
        
        }

        return $response->body();
    }
}
