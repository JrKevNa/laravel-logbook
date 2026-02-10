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
        //
        Schema::table('fingerprints', function (Blueprint $table) {
            $table->boolean('upload_user_info_to_machine')->default(false)->after('nik');
            $table->boolean('download_user_info_to_program')->default(false)->after('enroll_fingerprint');
            $table->boolean('upload_user_info_to_all_machine')->default(false)->after('download_user_info_to_program');
            $table->text('note')->nullable()->after('upload_user_info_to_all_machine');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
