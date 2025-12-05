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
        Schema::table('users', function (Blueprint $table) {
            // Add missing profile fields
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable();
            }

            if (!Schema::hasColumn('users', 'institution')) {
                $table->string('institution')->nullable();
            }

            if (!Schema::hasColumn('users', 'education_level')) {
                $table->string('education_level')->nullable();
            }

            if (!Schema::hasColumn('users', 'interests')) {
                $table->json('interests')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the added columns if rolling back
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('users', 'institution')) {
                $table->dropColumn('institution');
            }

            if (Schema::hasColumn('users', 'education_level')) {
                $table->dropColumn('education_level');
            }

            if (Schema::hasColumn('users', 'interests')) {
                $table->dropColumn('interests');
            }
        });
    }
};
