<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\ReportRequest;
use App\Models\Enums\CourseStatus;
use App\Models\Enums\CourseSubjectStatus;
use App\Models\Enums\ReportType;
use App\Models\Task;
use App\Models\User;

class ReportController extends Controller
{
    public function getUserTasksOfATaskWithLastedReport(Task $task)
    {
        $userTasks = $task->userTasks()
            ->with([
                'user',
                'reports' => function ($query) {
                    $query->orderBy('report_at', 'desc')->limit(1);
                }
            ])
            ->paginate(config('pagination.user_tasks.per_page', 12));

        $userTasks->getCollection()->transform(function ($userTask) {
            $report = $userTask->reports->first();

            return (object) [
                'id' => $userTask->id,
                'is_done' => $userTask->is_done,
                'lastedReport' => $report ? (object) [
                    'id' => $report->id,
                    'report_content' => $report->report_content,
                    'report_at' => formatDate($report->report_at),
                ] : null,
                'user' => (object) [
                    'id' => $userTask->user->id,
                    'name' => $userTask->user->name,
                    'email' => $userTask->user->email,
                ],
            ];
        });

        return view('tasks.reports.users', [
            'task' => (object) [
                'id' => $task->id,
                'title' => $task->title,
            ],
            'userTasks' => $userTasks,
        ]);
    }

    public function getReportsOfAUserTask(Task $task, User $user)
    {
        $userTask = $task->userTasks()->with(['user', 'task'])->where('user_id', $user->id)->first();

        if (!$userTask) {
            abort(404);
        }

        $reports = $userTask->reports()->with('sender')->orderBy('report_at', 'desc')->paginate(config('pagination.reports.per_page', 12));

        $reports->getCollection()->transform(function ($report) {

            return (object) [
                'id' => $report->id,
                'report_type' => $report->report_type,
                'report_content' => $report->report_content,
                'report_at' => $report->report_at,
                'sender' => (object) [
                    'id' => $report->sender->id,
                    'name' => $report->sender->name,
                    'email' => $report->sender->email,
                ]
            ];
        });

        return view('tasks.reports.user', [
            'task' => (object) [
                'id' => $userTask->task->id,
                'title' => $userTask->task->title,
                'is_done' => $userTask->is_done,
            ],
            'user' => (object) [
                'id' => $userTask->user->id,
                'name' => $userTask->user->name,
                'email' => $userTask->user->email,
            ],
            'reports' => $reports,
        ]);
    }

    private function isValidToPerform(Task $task, User $user)
    {
        $courseSubject = $task->courseSubject;
        $course = $courseSubject->course;

        $userWithCoursePivot = $course->trainees()->where('user_id', $user->id)->first();

        if (!$userWithCoursePivot) {
            return [false, $this->backWithNotification(__('task.trainee_not_in_course'))];
        }

        $isActive = $userWithCoursePivot->pivot?->is_active;

        if (!$isActive) {
            return [false, $this->backWithNotification(__('task.course_not_active'))];
        }

        if ($course->status != CourseStatus::STARTED) {
            return [false, $this->backWithNotification(__('task.course_not_started'))];
        }

        if ($courseSubject->status != CourseSubjectStatus::STARTED) {
            return [false, $this->backWithNotification(__('task.subject_not_started'))];
        }

        $userTask = $task->userTasks()->where('user_id', $user->id)->first();

        if (!$userTask) {
            return [false, $this->backWithNotification(__('task.trainee_not_report_yet'))];
        }

        if ($userTask->is_done) {
            return [false, $this->backWithNotification(__('task.task_already_completed'))];
        }

        return [true, $userTask];
    }

    public function commentAUserTask(ReportRequest $request, Task $task, User $user)
    {
        try {
            $isValidToPerform = $this->isValidToPerform($task, $user);

            if (!$isValidToPerform[0]) {
                return $isValidToPerform[1];
            }

            $userTask = $isValidToPerform[1];

            $data = $request->validated();

            $userTask->reports()->create([
                'sender_id' => $request->user()->id,
                'report_type' => ReportType::FEEDBACK,
                'report_content' => $data['report_content'],
                'report_at' => now(),
            ]);

            return redirect()
                ->route('tasks.reports.user_task', ['task' => $task->id, 'user' => $user->id])
                ->with('notification', __('task.comment_report_success'));
        } catch (\Throwable $e) {
            Log::error('Report comment failed: ' . $e->getMessage(), ['exception' => $e]);
            return $this->backWithNotification(__('task.comment_report_failed'));
        }
    }

    public function markAsDone(Task $task, User $user)
    {
        try {
            $isValidToPerform = $this->isValidToPerform($task, $user);

            if (!$isValidToPerform[0]) {
                return $isValidToPerform[1];
            }

            $userTask = $isValidToPerform[1];

            $userTask->update(['is_done' => true, 'done_at' => now()]);

            return redirect()
                ->route('tasks.reports.user_task', ['task' => $task->id, 'user' => $user->id])
                ->with('notification', __('task.mark_as_done_success'));
        } catch (\Throwable $e) {
            Log::error('Mark task as done failed: ' . $e->getMessage(), ['exception' => $e]);
            return $this->backWithNotification(__('task.mark_as_done_failed'));
        }
    }
}
