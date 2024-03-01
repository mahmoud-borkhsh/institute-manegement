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
        Schema::create('grades_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('mark');
            $table->integer('tuition_fees');
            $table->integer('sessions_count');
            $table->foreignId('grade_id')->constrained('grades');
            $table->foreignId('course_id')->constrained('courses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades_courses');
    }
};
