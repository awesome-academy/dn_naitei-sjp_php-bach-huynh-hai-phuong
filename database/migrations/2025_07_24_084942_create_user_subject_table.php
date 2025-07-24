<?php

use App\Models\Enums\UserSubjectStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_subject_id')->constrained('course_subject')->onDelete('cascade');
            $table->enum('status', array_map(fn($case) => $case->value, UserSubjectStatus::cases()))->default(UserSubjectStatus::NOT_STARTED);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subject');
    }
};
