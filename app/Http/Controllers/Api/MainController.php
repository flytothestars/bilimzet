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
        $date = date('Y-m-d H:i:s');
        $invoiceId = rand(00000000,99999999);
        $amount = 200.00;
        $control = md5($invoiceId . $amount . $date . 'K5a8F1rxGJCis60upTi597oI1');
        $data = [
            'orderid'       => $invoiceId,
            'amount'        => $amount,
            'dt'            => $date,
            'control'       => $control,
            'description'   => 'Покупка билета',
            'redirect_url'  => 'www.youtube.com',
            'account'       => '3107',
            'merchant_site' => 'www.google.com',
        ];
        try {
            $response = $this->makeRequest($data, 'https://sredapay.kz/sbp-qr/partner/3107/pay');
            $redirectData = $this->getData($response);
            // $data = json_decode($response, true);

            return $redirectData['link'];
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

        $response = Http::timeout(30)
            ->post($fullUrl); 

        Log::info('SSBPPaymentServiceBP makeRequest ответ:' . json_encode($response->body()));

        if ($response->failed()) {
            throw new Exception('HTTP request failed: ' . $response->body());
        }

        return $response->body();
    }
}
