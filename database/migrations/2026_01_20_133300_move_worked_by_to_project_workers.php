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
        // 1. Create the pivot table if not already created
        Schema::create('project_workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        // 2. Transfer existing data from projects.worked_by
        $projects = DB::table('projects')->whereNotNull('worked_by')->get();

        foreach ($projects as $project) {
            DB::table('project_workers')->insert([
                'project_id' => $project->id,
                'user_id' => $project->worked_by,
                'company_id' => $project->company_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Drop the old column (after data is moved)
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['worked_by']); // drop FK if exists
            $table->dropColumn('worked_by');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // 1. Re-add the column
            Schema::table('projects', function (Blueprint $table) {
                $table->unsignedBigInteger('worked_by')->nullable();
            });

            // 2. Move data back
            $workers = DB::table('project_workers')->get();
            foreach ($workers as $worker) {
                DB::table('projects')->where('id', $worker->project_id)->update([
                    'worked_by' => $worker->user_id,
                ]);
            }

            // 3. Drop the pivot table
            Schema::dropIfExists('project_workers');
        });
    }
};
