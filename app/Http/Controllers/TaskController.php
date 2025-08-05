<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Subject;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function create(Course $course, Subject $subject)
    {
        return view('tasks.task', compact('course', 'subject'));
    }

    public function store(CreateTaskRequest $request, Course $course, Subject $subject)
    {
        $data = $request->validated();

        try {
            $courseSubject = CourseSubject::where('course_id', $course->id)
                ->where('subject_id', $subject->id)
                ->firstOrFail();

            $maxSortOrder = $courseSubject->tasks()->max('sort_order') ?? 0;
            $data['sort_order'] = $maxSortOrder + 1;

            $courseSubject->tasks()->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'sort_order' => $data['sort_order'],
            ]);

            return redirect()
                ->route('courses.show', $course->id)
                ->with('notification', __('task.task_added'));
        } catch (\Throwable $e) {
            Log::error('Task create failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('task.task_create_failed'))->withInput();
        }

    }

    public function edit(Task $task)
    {
        try {
            $courseSubject = $task->courseSubject;
            $course = $courseSubject->course;
            $subject = $courseSubject->subject;

            return view('tasks.task', compact('task', 'course', 'subject'));
        } catch (\Throwable $e) {
            Log::error('Task show edit failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('task.task_show_edit_failed'));
        }
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        try {
            $task->update($data);

            $courseId = $task->courseSubject->course_id;

            return redirect()
                ->route('courses.show', $courseId)
                ->with('notification', __('task.task_updated'));
        } catch (\Throwable $e) {
            Log::error('Task update failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('task.task_update_failed'))->withInput();
        }
    }

}
