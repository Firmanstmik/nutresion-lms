<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('nutrition_measurements')) {
            return;
        }

        Schema::create('nutrition_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('measured_at');

            // Snapshot of the profile at measurement time so history stays reproducible
            // even if the student's profile is corrected later.
            $table->date('birth_date');
            $table->string('sex', 6);
            $table->unsignedSmallInteger('age_months');

            $table->decimal('weight_kg', 5, 2);
            $table->decimal('height_cm', 5, 1);

            // Full precision; rounding happens only in the views.
            $table->decimal('bmi', 8, 4);
            $table->decimal('z_score', 8, 4);
            $table->string('category', 20);
            $table->string('reference_version', 60);

            $table->timestamps();

            $table->index(['user_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutrition_measurements');
    }
};
