<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_reviews', function (Blueprint $table) {
            $table->text('admin_reply')->nullable()->after('message');
            $table->string('admin_reply_author', 120)->nullable()->after('admin_reply');
            $table->timestamp('replied_at')->nullable()->after('admin_reply_author');
        });
    }

    public function down(): void
    {
        Schema::table('service_reviews', function (Blueprint $table) {
            $table->dropColumn(['admin_reply', 'admin_reply_author', 'replied_at']);
        });
    }
};
