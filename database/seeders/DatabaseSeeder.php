<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enums\CourseSubjectStatus;
use App\Models\Enums\Role;
use App\Models\Subject;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'role' => Role::SUPERVISOR,
        ]);

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@email.com',
            'role' => Role::TRAINEE,
        ]);


        // Seed course and subject, and add subjects to course
        $subjectCount = 10;
        $courseCount = 3;
        $minSubjectsPerCourse = 2;
        $maxSubjectsPerCourse = 5;

        $subjects = Subject::factory($subjectCount)->create();
        $courses = Course::factory($courseCount)->create();

        foreach ($courses as $course) {
            $randomSubjects = $subjects->random(rand($minSubjectsPerCourse, $maxSubjectsPerCourse))->values();

            foreach ($randomSubjects as $index => $subject) {
                $course->subjects()->attach(
                    $subject->id,
                    [
                        'sort_order' => $index + 1,
                        'status' => CourseSubjectStatus::NOT_STARTED,
                        'estimated_duration_days' => rand(1, 10),
                    ]
                );
            }
        }
    }
}
