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
        Schema::create('detail_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('activity'); // Project name
            $table->date('request_date');
            $table->unsignedBigInteger('worked_by'); // User assigned to work
            $table->string("requested_by"); // User who requested
            $table->text('note')->nullable(); // Optional note
            $table->unsignedBigInteger('company_id'); // Foreign key to company
            $table->unsignedBigInteger('created_by'); // User who created
            $table->unsignedBigInteger('updated_by')->nullable(); // User who updated
            $table->boolean('is_done')->default(false); // Done status
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('worked_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_projects');
    }
};
