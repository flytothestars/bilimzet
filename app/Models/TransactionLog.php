<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'pg_order_id',
        'pg_payment_id',
        'pg_amount',
        'pg_currency',
        'pg_net_amount',
        'pg_ps_amount',
        'pg_ps_full_amount',
        'pg_ps_currency',
        'pg_description',
        'pg_result',
        'pg_can_reject',
        'pg_user_phone',
        'pg_need_phone_notification',
        'pg_user_contact_email',
        'pg_need_email_notification',
        'pg_testing_mode',
        'pg_payment_method',
        'pg_captured',
        'pg_failure_description',
        'pg_failure_code',
        'pg_salt',
        'pg_sig',
    ];
}
