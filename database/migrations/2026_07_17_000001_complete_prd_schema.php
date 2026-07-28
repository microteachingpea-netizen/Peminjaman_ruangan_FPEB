<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'prodi')) {
                $table->string('prodi')->nullable()->after('role');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('bookings', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('bookings', 'prodi')) {
                $table->string('prodi')->nullable()->after('applicant');
            }
            if (! Schema::hasColumn('bookings', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('reason');
            }
        });

        if (! Schema::hasTable('notifs')) {
            Schema::create('notifs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('room_facility')) {
            Schema::create('room_facility', function (Blueprint $table) {
                $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
                $table->foreignId('facility_id')->constrained('facilities')->cascadeOnDelete();
                $table->primary(['room_id', 'facility_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('room_facility');
        Schema::dropIfExists('notifs');

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
            if (Schema::hasColumn('bookings', 'prodi')) {
                $table->dropColumn('prodi');
            }
            if (Schema::hasColumn('bookings', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'prodi')) {
                $table->dropColumn('prodi');
            }
        });
    }
};
