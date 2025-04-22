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
        Schema::table('promotions', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('title_kz')->nullable()->change();
            $table->string('description_kz')->nullable()->change();
            $table->string('link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
            $table->string('title_kz')->nullable(false)->change();
            $table->string('description_kz')->nullable(false)->change();
            $table->string('link')->nullable(false)->change();
        });
    }
};
