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
        Schema::table('comments', function (Blueprint $table) {
            $table->string('commentable_type')->default('App\Models\Post')->after('id');
            $table->unsignedBigInteger('commentable_id')->after('commentable_type');
            
            // Make post_id nullable for polymorphic relationships
            $table->unsignedBigInteger('post_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('commentable_type');
            $table->dropColumn('commentable_id');
            $table->unsignedBigInteger('post_id')->nullable(false)->change();
        });
    }
};
