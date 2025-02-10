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
        Schema::table('course_module_lectures', function (Blueprint $table) {
            $table->text('content')->change();
            $table->text('content_kz')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_module_lectures', function (Blueprint $table) {
            $table->string('content')->change();
            $table->string('content_kz')->change();

        });
    }
};
