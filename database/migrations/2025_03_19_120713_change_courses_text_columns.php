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
            $table->longText('form_training')->nullable()->change();
            $table->longText('form_training_kz')->nullable()->change();
            $table->longText('valid_period')->nullable()->change();
            $table->longText('valid_period_kz')->nullable()->change();
            $table->longText('issuance_certificate')->nullable()->change();
            $table->longText('issuance_certificate_kz')->nullable()->change();
            $table->longText('certificate_text')->nullable()->change();
            $table->longText('certificate_text_kz')->nullable()->change();

            $table->longText('title')->change();
            $table->longText('title_kz')->change();
            $table->longText('desc_text')->change();
            $table->longText('desc_text_kz')->change();
            $table->longText('listeners_category_text')->change();
            $table->longText('listeners_category_text_kz')->change();
            $table->longText('goals_text')->change();
            $table->longText('goals_text_kz')->change();
            $table->longText('tasks_text')->change();
            $table->longText('tasks_text_kz')->change();
            $table->longText('organization_text')->change();
            $table->longText('organization_text_kz')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('form_training')->nullable()->change();
            $table->string('form_training_kz')->nullable()->change();
            $table->string('valid_period')->nullable()->change();
            $table->string('valid_period_kz')->nullable()->change();
            $table->string('issuance_certificate')->nullable()->change();
            $table->string('issuance_certificate_kz')->nullable()->change();
            $table->string('certificate_text')->nullable()->change();
            $table->string('certificate_text_kz')->nullable()->change();

            $table->string('title')->change();
            $table->string('title_kz')->change();
            $table->text('desc_text')->change();
            $table->text('desc_text_kz')->change();
            $table->text('listeners_category_text')->change();
            $table->text('listeners_category_text_kz')->change();
            $table->text('goals_text')->change();
            $table->text('goals_text_kz')->change();
            $table->text('tasks_text')->change();
            $table->text('tasks_text_kz')->change();
            $table->text('organization_text')->change();
            $table->text('organization_text_kz')->change();
        });
    }
};
