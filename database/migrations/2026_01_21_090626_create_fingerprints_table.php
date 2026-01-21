<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Fingerprint;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fingerprints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->boolean('enroll_fingerprint')->default(false);
            $table->unsignedBigInteger('company_id'); // Foreign key to company
            $table->unsignedBigInteger('created_by'); // User who created
            $table->unsignedBigInteger('updated_by')->nullable(); // User who updated
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });

        // BACKFILL EXISTING USERS
        // 1. Get first admin per company
        $companyAdmins = User::whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            })
            ->orderBy('id') // "first admin" = lowest ID
            ->get()
            ->groupBy('company_id')
            ->map(fn ($users) => $users->first());

        // 2. Backfill fingerprints
        User::doesntHave('fingerprint')
            ->chunk(200, function ($users) use ($companyAdmins) {
                foreach ($users as $user) {
                    $admin = $companyAdmins[$user->company_id] ?? null;

                    // HARD FAIL if no admin exists (better than silent corruption)
                    if (!$admin) {
                        throw new \RuntimeException(
                            "No admin found for company {$user->company_id}"
                        );
                    }

                    Fingerprint::create([
                        'user_id'    => $user->id,
                        'company_id' => $user->company_id,
                        'created_by' => $admin->id,
                    ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fingerprints');
    }
};
