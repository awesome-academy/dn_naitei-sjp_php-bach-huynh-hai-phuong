<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_subject_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_subject_id')->constrained('course_subject')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_subject_tasks');
    }
};
