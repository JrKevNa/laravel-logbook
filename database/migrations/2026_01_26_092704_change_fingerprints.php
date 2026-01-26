<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        // Delete all existing fingerprints first
        DB::table('fingerprints')->truncate();

        Schema::table('fingerprints', function (Blueprint $table) {
            // drop the old user_id column & its foreign key
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // add independent fields
            $table->string('name')->after('id');
            $table->string('nik')->nullable()->after('name'); // if not always available
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fingerprints', function (Blueprint $table) {
            // drop new columns
            $table->dropColumn(['name', 'nik']);

            // restore old user_id
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
