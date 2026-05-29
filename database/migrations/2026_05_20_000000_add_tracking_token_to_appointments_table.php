<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('appointments') || Schema::hasColumn('appointments', 'tracking_token')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->string('tracking_token', 64)->nullable()->unique()->after('message');
        });

        DB::table('appointments')
            ->whereNull('tracking_token')
            ->orderBy('id')
            ->select('id')
            ->each(function ($appointment) {
                DB::table('appointments')
                    ->where('id', $appointment->id)
                    ->update(['tracking_token' => 'ADF-'.now()->format('Y').'-'.Str::upper(Str::random(10))]);
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('appointments') || ! Schema::hasColumn('appointments', 'tracking_token')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropUnique(['tracking_token']);
            $table->dropColumn('tracking_token');
        });
    }
};
