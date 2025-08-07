<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Enums\CourseStatus;
use App\Models\Enums\CourseSubjectStatus;
use App\Models\Enums\ReportType;
use App\Models\Enums\UserSubjectStatus;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Task Reports",
 *     description="Submit and view task reports"
 * )
 */
class ReportController extends Controller
{
    /**
     * Submit a report for a task.
     *
     * @OA\Post(
     *     path="/tasks/{task}/reports",
     *     operationId="submitTaskReport",
     *     tags={"Task Reports"},
     *     summary="Submit a report for a task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"report_content"},
     *             @OA\Property(property="report_content", type="string", minLength=3, maxLength=1000, example="I have completed the reading assignment.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Report submitted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Report"),
     *             @OA\Property(property="message", type="string", example="Report submitted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - task not accessible or not in progress",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="You are not enrolled in this course."),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict - task already completed",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Task already completed"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     )
     * )
     */
    public function store(ReportRequest $request, Task $task): JsonResponse
    {
        $user = $request->user();
        $courseSubject = $task->courseSubject;
        $course = $courseSubject->course;

        $isTraineeInCourse = $course->trainees->contains($user->id);
        if (!$isTraineeInCourse) {
            return $this->error(__('task.not_in_course'), [], Response::HTTP_FORBIDDEN);
        }

        if ($course->status != CourseStatus::STARTED) {
            return $this->error(__('task.course_not_started'), [], Response::HTTP_FORBIDDEN);
        }

        if ($courseSubject->status != CourseSubjectStatus::STARTED) {
            return $this->error(__('task.subject_not_started'), [], Response::HTTP_FORBIDDEN);
        }

        $isFirstTaskOfSubject = !$courseSubject->users->contains($user->id);
        if ($isFirstTaskOfSubject) {
            $courseSubject->users()->attach($user->id, ['status' => UserSubjectStatus::IN_PROGRESS]);
        }

        $userWithSubjectPivot = $courseSubject->users()->where('user_id', $user->id)->first();
        if ($userWithSubjectPivot->pivot?->status != UserSubjectStatus::IN_PROGRESS->value) {
            return $this->error(__('task.subject_not_in_progress'), [], Response::HTTP_FORBIDDEN);
        }

        $isFirstReportOfTask = !$task->users->contains($user->id);
        if ($isFirstReportOfTask) {
            $task->users()->attach($user->id);
        }

        $userTask = $task->userTasks()->where('user_id', $user->id)->first();

        if ($userTask->isDone) {
            return $this->error(__('task.task_already_completed'), [], Response::HTTP_CONFLICT);
        }

        $data = $request->validated();

        $report = $userTask->reports()->create([
            'sender_id' => $user->id,
            'report_type' => ReportType::REPORT,
            'report_content' => $data['report_content'],
            'report_at' => now(),
        ]);

        return $this->success($report, __('task.reported'), Response::HTTP_CREATED);
    }

    /**
     * Get all reports submitted by the current user for a task.
     *
     * @OA\Get(
     *     path="/tasks/{task}/reports",
     *     operationId="getTaskReports",
     *     tags={"Task Reports"},
     *     summary="List task reports submitted by the authenticated user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of reports",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Report")),
     *             @OA\Property(property="message", type="string", example="OK")
     *         )
     *     )
     * )
     */    
    public function index(Request $request, Task $task): JsonResponse
    {
        $user = $request->user();

        $task->load([
            'userTasks' => function ($userTasksQuery) use ($user) {
                $userTasksQuery->where('user_id', $user->id)
                    ->with([
                        'reports' => function ($userTasksReportsQuery) {
                            $userTasksReportsQuery
                                ->with('sender')
                                ->orderBy('report_at', 'desc');
                        }
                    ]);
            }
        ]);

        $reports = collect();

        if ($task->userTasks->isNotEmpty()) {
            $reports = $task->userTasks->flatMap->reports;
        }

        return $this->success(ReportResource::collection($reports));
    }
}
