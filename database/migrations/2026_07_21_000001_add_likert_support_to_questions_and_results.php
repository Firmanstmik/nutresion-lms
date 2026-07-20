<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('format', 32)->default('multiple_choice')->after('type');
            $table->string('polarity', 16)->nullable()->after('format');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->string('option_a')->nullable()->change();
            $table->string('option_b')->nullable()->change();
            $table->string('option_c')->nullable()->change();
            $table->string('option_d')->nullable()->change();
            $table->string('correct_answer')->nullable()->change();
        });

        Schema::table('result_answers', function (Blueprint $table) {
            $table->string('selected_answer', 16)->nullable()->change();
            $table->unsignedTinyInteger('points')->nullable()->after('is_correct');
        });

        Schema::table('results', function (Blueprint $table) {
            $table->unsignedSmallInteger('mc_score')->nullable()->after('score');
            $table->unsignedSmallInteger('likert_score')->nullable()->after('mc_score');
        });
    }

    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['mc_score', 'likert_score']);
        });

        Schema::table('result_answers', function (Blueprint $table) {
            $table->dropColumn('points');
            $table->string('selected_answer', 1)->nullable()->change();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['format', 'polarity']);
            $table->string('option_a')->nullable(false)->change();
            $table->string('option_b')->nullable(false)->change();
            $table->string('option_c')->nullable(false)->change();
            $table->string('option_d')->nullable(false)->change();
            $table->string('correct_answer')->nullable(false)->change();
        });
    }
};
