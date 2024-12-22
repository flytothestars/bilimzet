<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('pg_order_id');
            $table->string('pg_payment_id');
            $table->decimal('pg_amount', 10, 2);
            $table->string('pg_currency');
            $table->decimal('pg_net_amount', 10, 2);
            $table->decimal('pg_ps_amount', 10, 2);
            $table->decimal('pg_ps_full_amount', 10, 2);
            $table->string('pg_ps_currency');
            $table->text('pg_description');
            $table->boolean('pg_result');
            $table->timestamp('pg_payment_date');
            $table->boolean('pg_can_reject');
            $table->string('pg_user_phone');
            $table->boolean('pg_need_phone_notification');
            $table->string('pg_user_contact_email');
            $table->boolean('pg_need_email_notification');
            $table->boolean('pg_testing_mode');
            $table->string('pg_payment_method');
            $table->string('pg_reference')->nullable();
            $table->boolean('pg_captured');
            $table->string('pg_card_pan')->nullable();
            $table->string('pg_card_exp')->nullable();
            $table->string('pg_card_owner')->nullable();
            $table->string('pg_card_brand')->nullable();
            $table->string('pg_auth_code')->nullable();
            $table->string('pg_failure_description')->nullable();
            $table->string('pg_failure_code')->nullable();
            $table->string('pg_salt');
            $table->string('pg_sig');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
