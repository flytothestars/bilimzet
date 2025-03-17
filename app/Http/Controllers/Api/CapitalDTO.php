<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CapitalDTO
{
    public $time;
    public $data;
    public $token;
    public $event_name;

    public function __construct($data, $token)
    {
        $this->time = date('Y-m-d H:i:s');
        $this->data = $data['data'];
        $this->token = $token;
        $this->event_name = $data['event_name'];
        Log::debug("capital dto in");
    }

    public function toArray()
    {
        return [
            'time' => $this->time,
            'data' => $this->data,
            'token' => $this->token,
            'event_name' => $this->event_name,
        ];
    }
}
