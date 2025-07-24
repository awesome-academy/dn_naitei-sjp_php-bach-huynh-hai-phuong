<?php

use App\Models\Enums\ReportType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_task_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_task_id')->constrained('user_task')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->enum('report_type', array_map(fn($case) => $case->value, ReportType::cases()))->default(ReportType::FEEDBACK);
            $table->text('report_content');
            $table->timestamp('report_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_task_reports');
    }
};
