<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('likes')->default(0)->after('views');
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->unsignedBigInteger('likes')->default(0)->after('views');
            $table->string('video_url')->nullable()->after('link');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('likes');
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['likes', 'video_url']);
        });
    }
};