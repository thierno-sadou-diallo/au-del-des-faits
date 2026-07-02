<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter les nouvelles colonnes à availability_slots
        Schema::table('availability_slots', function (Blueprint $table) {
            if (!Schema::hasColumn('availability_slots', 'available_date')) {
                $table->date('available_date')->nullable()->after('id');
            }
            if (!Schema::hasColumn('availability_slots', 'slot_type')) {
                $table->enum('slot_type', ['available', 'request'])->default('available')->after('available_date');
            }
        });

        // Modifier la colonne appointments pour ajouter is_approved
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'appointment_date')) {
                $table->date('appointment_date')->nullable()->after('availability_slot_id');
            }
            if (!Schema::hasColumn('appointments', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('availability_slots', function (Blueprint $table) {
            if (Schema::hasColumn('availability_slots', 'available_date')) {
                $table->dropColumn('available_date');
            }
            if (Schema::hasColumn('availability_slots', 'slot_type')) {
                $table->dropColumn('slot_type');
            }
        });

        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'appointment_date')) {
                $table->dropColumn('appointment_date');
            }
            if (Schema::hasColumn('appointments', 'is_approved')) {
                $table->dropColumn('is_approved');
            }
        });
    }
};
