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
        Schema::table('course_modules', function (Blueprint $table) {
            $table->boolean('is_lecture')->default(false);
            $table->boolean('is_video')->default(false);
            $table->boolean('is_present')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_modules', function (Blueprint $table) {
            $table->dropColumn(['is_lecture']);
            $table->dropColumn(['is_video']);
            $table->dropColumn(['is_present']);

        });
    }
};
