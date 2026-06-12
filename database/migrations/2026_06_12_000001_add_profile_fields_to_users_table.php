<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->string('role')->default('patient')->after('whatsapp'); // patient | staff
            $table->string('email_otp')->nullable()->after('password');
            $table->timestamp('email_otp_expires_at')->nullable()->after('email_otp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'whatsapp', 'role', 'email_otp', 'email_otp_expires_at']);
        });
    }
};
