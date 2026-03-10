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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('document_number')->nullable();
            $table->string('title')->nullable();
            $table->longText('header')->nullable();
            $table->json('sections')->nullable(); // dynamic array
            $table->string('amount')->nullable(); // store as string if you want formatted, or decimal
            $table->string('city')->nullable();
            $table->string('day_date')->nullable(); // you can also use date
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
