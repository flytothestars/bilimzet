<?php
return [
    'services'=> [
        'sbp' => [
            'config' => [
                'test' => true,
                'url_qr' => env('TICKETON_SBP_URL_QR','https://sredapay.kz/sbp-qr/partner/3107/pay'),
                'url_refund' => env('TICKETON_SBP_URL_REFUND','https://sredapay.kz/partner/3107/make_refund'),
                'url_check_pay' => env('TICKETON_SBP_URL_CHECK_PAY','https://sredapay.kz/3107/check_pay'),
                'url_process' => env('TICKETON_SBP_URL_PROCESS','https://ticketon.kz/api/v2/process/sbp'),
                'store_id' => env('TICKETON_SBP_SERVICE_ID','3107'),
                'secret_key' => env('TICKETON_SBP_SECRET_KEY','K5a8F1rxGJCis60upTi597oI1'),
                'type_pay' => env('TICKETON_SBP_TYPE_PAY','0'),
                'merchant_site' => env('TICKETON_SBP_MERCHANT_SITE'. 'www.ticketon.kz'),
            ]

        ],
    ]
];
