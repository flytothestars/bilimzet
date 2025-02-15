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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('form_training')->nullable();
            $table->string('form_training_kz')->nullable();
            $table->string('valid_period')->nullable();
            $table->string('valid_period_kz')->nullable();
            $table->string('issuance_certificate')->nullable();
            $table->string('issuance_certificate_kz')->nullable();
            $table->string('certificate_text')->nullable();
            $table->string('certificate_text_kz')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'form_training', 'form_training_kz',
                'valid_period','valid_period_kz',
                'issuance_certificate','issuance_certificate_kz',
                'certificate_text','certificate_text_kz'
            ]);
        });
    }
};
