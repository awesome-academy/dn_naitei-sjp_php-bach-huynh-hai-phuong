<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CourseResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Courses",
 *     description="Operations related to user courses"
 * )
 */
class CourseController extends Controller
{

    /**
     * Get all courses assigned to the authenticated user.
     *
     * @OA\Get(
     *     path="/courses",
     *     operationId="getUserCourses",
     *     tags={"Courses"},
     *     summary="List all courses for the authenticated user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of courses",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Course")),
     *             @OA\Property(property="message", type="string", example="OK")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $courses = $user->courses;

        return $this->success(CourseResource::collection($courses));
    }

    /**
     * Get a specific course by ID for the authenticated user.
     *
     * @OA\Get(
     *     path="/courses/{course}",
     *     operationId="getUserCourseDetail",
     *     tags={"Courses"},
     *     summary="Get course details by ID for the current user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="Course ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Course details",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Course"),
     *             @OA\Property(property="message", type="string", example="OK")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized access to course",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized access to course"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     )
     * )
     */
    public function show(Request $request, int $courseId): JsonResponse
    {
        $user = $request->user();

        $course = $user->courses()
            ->with([
                'courseSubjects' => function ($courseSubjectsQuery) use ($user) {
                    $courseSubjectsQuery->with([
                        'users' => function ($courseSubjectsUsersQuery) use ($user) {
                            $courseSubjectsUsersQuery->where('user_id', $user->id)->select('users.id');
                        },
                        'subject',
                        'tasks' => function ($courseSubjectsTasksQuery) use ($user) {
                            $courseSubjectsTasksQuery->with([
                                'users' => function ($courseSubjectsTasksUsersQuery) use ($user) {
                                    $courseSubjectsTasksUsersQuery->where('user_id', $user->id)->select('users.id');
                                }
                            ]);
                        },
                    ]);
                }
            ])
            ->where('courses.id', $courseId)->first();

        if (!$course) {
            return $this->error(__('course.unauthorized_access'), [], Response::HTTP_FORBIDDEN);
        }

        return $this->success(new CourseResource($course));
    }
}
